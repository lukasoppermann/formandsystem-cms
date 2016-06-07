<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;
use App\Services\ApiCollectionService;
use App\Services\ApiPageService;
use App\Entities\Collection;

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
    protected $collection;
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
        parent::__construct($request);
        // get the main pages collection
        $this->collection = $this->getPagesCollection();

        $this->collections = $items = (new ApiCollectionService)->all([
            'includes' => false
        ]);
    }
    /**
     * get main pages collection or create
     *
     * @method getPagesCollection
     *
     * @return App\Entities\Collection
     */
    public function getPagesCollection()
    {
        if( !$collection = (new ApiCollectionService)->first('slug','pages') ){
            $collection = (new ApiCollectionService)->create([
                'name' => 'pages',
                'slug' => 'pages',
            ]);
        }
        // return main pages collection
        return $collection;
    }

    public function getMenu()
    {
        $this->navigation['lists'] = $this->getMenuLists();
    }

    public function getMenuLists()
    {
        // TODO: deal with errors
        // get pages
        (new ApiCollectionService)->first('slug','pages',['includes' => ['pages']]);
        $collection = (new ApiCollectionService)->first('slug','pages',['includes' => ['pages']]);
        // get all ids of needed pages
        if(!$collection->pages->isEmpty()){
            $page_ids = $collection->pages->map(function($item) {
                return $item->id;
            });
            // // get all pages
            $pages = (new ApiPageService)->get($page_ids->toArray(),[
                'includes' => false
            ]);
            // turn pages into array
            $pages = $pages->map(function($item){
                $item = $item->toArray();
                $item['link'] = '/pages/'.$item['slug'];
                return $item;
            })->toArray();
        }
        // prepare for navigation
        return [
            [
                'items' => isset($pages) ? $pages : [],
                'item' => 'pages.navigation-item',
                'elements' => [
                    view('navigation.add', [
                        'action'    => '/pages',
                        'method'    => 'post',
                        'label'     => 'Add Page'
                    ])->render(),
                ]
            ]
        ];
    }

    public function index(){
        $this->getMenu();
        $data['navigation'] = $this->buildNavigation('/pages');
        return view('pages.dashboard', $data);
    }

    public function show($slug){
        $this->getMenu();
        $data['page'] = (new ApiPageService)->first('slug',$slug);

        if($data['page'] === NULL){
            return redirect('/pages');
        }

        $data['collection'] = $this->collection;
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
            $collection_id = (new ApiCollectionService)->first('slug','pages')->id;
        }else{
            $collection_id = $collection->get('collection');
        }

        $newPage = (new ApiPageService)->create($page->toArray());

        $response = $this->api($this->client)->post('/collections/'.$collection_id.'/relationships/pages', [
            'type' => 'pages',
            'id'   => $newPage['data']['id'],
        ]);

        if($collection->get('isInvalid')){
            return redirect('pages/'.$newPage['data']['attributes']['slug']);
        }

        return redirect('collections/'.(new ApiCollectionService)->get($collection_id)->slug.'/'.$newPage['data']['attributes']['slug']);
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
            $response = $this->api($this->client)->delete('/pages/'.$id);
        }

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
                ->with(['status' => 'Updating the page failed.', 'type' => 'error'])
                ->withErrors($validator)
                ->withInput();
        }
        // store detail
        try{
            $item = (new ApiPageService)->update(
                $request->input('id'),
                $request->only([
                    'menu_label',
                    'slug',
                    'title',
                    'description',
                ])
            );
            // redirect on success
            if($slug = $request->get('slug')){
                $collection = (new ApiCollectionService)->get($request->get('collection'))->slug;

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
