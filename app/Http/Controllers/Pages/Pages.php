<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Requests;
use Cache;
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
        if(!Cache::has('pages.collection')){
            if( !$collection = (new ApiCollectionService)->find('slug','pages') ){
                $collection = (new ApiCollectionService)->create('pages');
            }
            // cache collection
            Cache::put(
                'pages.collection',
                $collection,
                Carbon::now()->addMinutes(10)
            );
        }
        // return main pages collection
        return Cache::get('pages.collection');
    }

    public function getMenu()
    {
        if(!Cache::has('pages.navigation')){
            Cache::forever('pages.navigation', $this->getMenuLists());
        }

        $this->navigation['lists'] = Cache::get('pages.navigation');
    }

    public function getMenuLists()
    {
        // TODO: deal with errors
        // get pages
        $collection = (new ApiCollectionService)->first('slug','pages',['includes' => ['pages']]);
        // get all ids of needed pages
        if($collection->pages !== NULL){
            $page_ids = $collection->pages->map(function($item) {
                return $item->id;
            });
            // $page_ids[] = 'cf6a3a83-4c39-34a1-910c-b43d7121a0fa';
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
                'add' => [
                    'link' => '/pages/create'
                ],
                'item' => 'pages.navigation-item',
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
        $data['navigation'] = $this->buildNavigation('/pages/'.$slug);

        return view('pages.page', $data);
    }
    /**
     * create new page instance
     *
     * @method store
     */
    public function store()
    {
        $page = (new ApiPageService)->store([
            'menu_label' => 'New Page',
            'slug'       => 'new-page',
            'published'  => false,
            'language'  => 'de',
        ]);

        $collection = (new ApiCollectionService)->first('slug','pages');

        $response = $this->api($this->client)->post('/collections/'.$collection->id.'/relationships/pages', [
            'type' => 'pages',
            'id'   => $page['data']['id'],
        ]);

        Cache::forget('pages.navigation');
        Cache::forget('pages.collection');

        return redirect('pages/new-page');
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

        Cache::forget('pages.navigation');
        Cache::forget('pages.collection');

        return redirect('pages');
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
            $item = (new ApiPageService)->update([
                'id' => $request->input('id'),
                'attributes' => $request->only([
                    'menu_label',
                    'slug',
                    'title',
                    'description',
                ])
             ]);
            // redirect on success
            if($request->get('slug') || $request->get('menu_label')){
                Cache::forget('pages.navigation');
                Cache::forget('pages.collection');
            }
            if($slug = $request->get('slug')){
                return redirect('/pages/'.$slug)->with([
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
