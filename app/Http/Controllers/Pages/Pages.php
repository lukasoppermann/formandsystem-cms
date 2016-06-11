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
use Illuminate\Support\Collection as LaravelCollection;

class Pages extends Controller
{
    /**
     * main navigation array
     *
     * @var array
     */
    protected $navigation = [
        'header' => [
            'title' => 'Pages',
            'link' => '/',
        ],
    ];
    /**
     * pages collection
     *
     * @var App\Entities\Collection
     */
    protected $navigations;
    /**
     * collections
     */
    protected $collections;
    /**
     * construct
     *
     * @method __construct
     *
     * @param  Request     $request
     */
    public function __construct(Request $request)
    {
        //at beginning
        // config(['app.milliseconds' => round(microtime(true) * 1000)]);
        parent::__construct($request);
        // echo round(microtime(true) * 1000) - config('app.milliseconds').'s<br />';
        // config(['app.milliseconds' => round(microtime(true) * 1000)]);
        // get the main pages collection
    }
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

    public function getMenu()
    {
        $this->navigation['lists'] = $this->getMenuLists();
    }

    public function getMenuLists()
    {
        $lists = [];
        // TODO: deal with errors
        foreach($this->navigations as $list) {
            $lists[$list->slug] = [
                'title' => $list->name,
                'items' => $list->pages->map(function($item){
                    $item = $item->toArray();
                    $item['link'] = '/pages/'.$item['slug'];
                    return $item;
                })->toArray(),
                'item' => 'pages.navigation-item',
                'elements' => [
                    view('navigation.add', [
                        'action'    => '/pages',
                        'method'    => 'post',
                        'label'     => 'Add Page'
                    ])->render(),
                ]
            ];
        };
        // prepare for navigation
        return $lists;
    }

    public function index(){
        $this->navigations = $this->getPagesCollections();

        $this->collections = $items = (new CollectionService)->all([
            'includes' => false
        ]);

        $this->getMenu();
        $data['navigation'] = $this->buildNavigation('/pages');
        return view('pages.dashboard', $data);
    }

    public function show($slug){
        $this->navigations = $this->getPagesCollections();

        $this->collections = $items = (new CollectionService)->all([
            'includes' => false
        ]);
        $this->getMenu();
        $data['page'] = (new PageService)->first('slug',$slug,['includes' => ['ownedByCollections']]);

        if($data['page'] === NULL){
            return redirect('/pages');
        }

        $data['collection'] = $data['page']->ownedByCollections->first();
        $data['collections'] = $this->collections;
        $data['navigation'] = $this->buildNavigation('/pages/'.$slug);

        return view('pages.page', $data);
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
            'published'  => false,
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

        $response = $this->api($this->client)->post('/collections/'.$collection_id.'/relationships/pages', [
            'type' => 'pages',
            'id'   => $newPage['data']['id'],
        ]);

        (new CollectionService)->clearCache();

        if($collection->get('isInvalid')){
            return redirect('pages/'.$newPage['data']['attributes']['slug']);
        }

        return redirect('collections/'.(new CollectionService)->get($collection_id)->slug.'/'.$newPage['data']['attributes']['slug']);
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
                $collection = (new CollectionService)->get($request->get('collection'))->slug;

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
