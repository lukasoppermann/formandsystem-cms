<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\Api\CollectionService;
use App\Services\Api\PageService;
use App\Entities\Collection;
use App\Entities\Page;
use Illuminate\Support\Collection as LaravelCollection;

class Pages extends Controller
{
    /**
     * collections
     */
    protected $collections;
    /**
     * get main pages collection or create
     *
     * @method getPagesCollection
     *
     * @return App\Entities\Collection
     */
    public function getPagesCollections()
    {
        if( ($collections = (new CollectionService)->find('type','navigation',[
                'includes' => ['pages','fragments']
            ]))->isEmpty() ){
            $collections = new LaravelCollection((new CollectionService)->create([
                'name' => 'Main Navigation',
                'slug' => 'main-navigation',
                'type' => 'navigation'
            ]));
        }
        // return main pages collection
        return $collections;
    }

    public function index(){
        // $page = new Page([
        //     'menu_label'    => 'Tester '.rand(),
        //     'slug'          => 'slug',
        //     'published'     => 1,
        //     'language'      => 'de'
        // ]);
        // \Log::debug(new Page($page['id']));
        $page = new Page('bd958340-617a-4fd2-b786-9790d0065b05');
        // dd('Automatic realted items e.g. metadetails need to remove on Item not found due to delete.');
        // (new \App\Entities\Metadetail('ffe8b203-1e05-4046-9a53-b6bd6dcd45a4'))->delete();
        // $page->attach(new \App\Entities\Metadetail([
        //     'type' => 'Test-'.rand(),
        //     'data' => 'yo'
        // ]));
        return view('pages.dashboard');
    }

    public function show($slug)
    {


        $page = NULL;
        foreach(config('app.user')->account()->navigation() as $collection){
            if( $new_page = $collection->pages()->where('slug', $slug)){
                $page = $new_page->first();
            }
        }

        //
        // $page = (new PageService)->first('slug',$slug,['includes' => [
        //     'ownedByCollections',
        //     'metadetails',
        //     'fragments',
        //     'fragments.images',
        //     'fragments.metadetails',
        //     'fragments.fragments',
        // ]]);

        // if($page === NULL){
        //     return redirect('/pages');
        // }
        return view('pages.page', [
            'item'          => $page,
            'collection'    => $page->parentCollection(),
            'collections'   => $page->collections('type','posts'),
        ]);
    }
    /**
     * create new page instance
     *
     * @method store
     */
    public function store(Request $request)
    {
        // get page data
        $page = $this->getValidated($request, [
            'menu_label' => 'string',
            'slug'       => 'string',
            'published'  => 'boolean',
            'language'   => 'string',
        ], [
            'menu_label' => 'New Item',
            'slug'       => 'new-item-'.rand(),
            'published'  => true,
            'language'  => 'de',
        ]);
        // if validation fails
        if($page->get('isInvalid')){
            return false;
        }
        // get collection data
        $collection = $this->getValidated($request, [
            'collection' => 'required|string',
        ]);
        // if validation fails
        if($collection->get('isInvalid')){
            $collection_id = (new CollectionService)->first('slug','pages')->id;
        }else{
            $collection_id = $collection->get('collection');
        }
        $newPage = (new PageService)->create($page->toArray());

        $response = $this->api(config('app.user_client'))->post('/collections/'.$collection_id.'/relationships/pages', [
            'type' => 'pages',
            'id'   => $newPage['data']['id'],
        ]);

        (new CollectionService)->clearCache();

        if($collection->get('isInvalid')){
            return redirect('pages/'.$newPage['data']['attributes']['slug']);
        }

        return redirect('collections/'.(new CollectionService)->find('id',$collection_id)->slug.'/'.$newPage['data']['attributes']['slug']);
    }
    /**
     * delete a page
     *
     * @method delete
     */
    public function delete($id = NULL)
    {
        // TODO: deal with errors
        if($id !== NULL){
            $response = (new PageService)->delete($id);
        }
        // clear cache
        (new CollectionService)->clearCache();
        // return to pages
        return back();
    }
    /**
     * update a page
     *
     * @method update
     */
    public function update(Request $request)
    {
        // transform input
        $request->replace(
            array_merge(
                $request->only([
                    'id',
                    'menu_label',
                    'slug',
                    'title',
                    'description',
                    'collection',
                ]),
                [
                    'slug' => $request->get('slug') !== NULL ? strtolower($request->get('slug')) : NULL,
                ]
            )
        );
        // validate input
         $validator = Validator::make($request->all(), [
            'id'                => 'required|string',
            'menu_label'        => 'required|string',
            'slug'              => 'required|alpha_dash',
            'title'             => 'required|string',
            'description'       => 'required|string',
        ]);
        // if validation fails
        if($validator->fails()){
            return back()
                ->with(['status' => 'Updating the page failed. Please check the settings section.', 'type' => 'error'])
                ->withErrors($validator)
                ->withInput();
        }
        // store detail
        try{
            $item = (new PageService)->update(
                $request->input('id'),
                $request->only([
                    'menu_label',
                    'slug',
                    'title',
                    'description',
                ])
            );
            // clear collection cache
            (new CollectionService)->clearCache();
            // redirect on success
            if($slug = $request->get('slug')){
                $collection = (new CollectionService)->find('id',$request->get('collection'))->slug;

                if($collection !== 'pages'){
                    $collection = 'collections/'.$collection;
                }

                return redirect('/'.$collection.'/'.$slug)->with([
                    'status' => 'This page has been updated successfully.',
                    'type' => 'success'
                ]);
            }
            return back()->with([
                'status' => 'This page has been updated successfully.',
                'type' => 'success'
            ]);
        }catch(Exception $e){
            \Log::error($e);

            return back()->with(['status' => 'Saving this page failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
        }
    }
}
