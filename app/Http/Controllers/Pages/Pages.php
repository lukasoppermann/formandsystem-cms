<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Requests;
use Cache;
use Carbon\Carbon;
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
            if( !$collection = (new ApiCollectionService)->find('pages') ){
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
        Cache::forget('pages.navigation');
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

        $collection = (new ApiCollectionService)->find('pages');

        $response = $this->api($this->client)->post('/collections/'.$collection->id.'/relationships/pages', [
            'type' => 'pages',
            'id'   => $page['data']['id'],
        ]);

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

        return redirect('pages');
    }
}
