<?php

namespace App\Http\Controllers\Collections;

use Illuminate\Http\Request;
use Cache;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ApiCollectionService;

class Collections extends Controller
{
    /**
     * main navigation array
     *
     * @var array
     */
    protected $navigation = [
        'header' => [
            'title' => 'Collections',
            'link' => '/',
        ]
    ];
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
        // get the main navigation items
        $this->getMenu();
    }

    public function getMenu()
    {
        Cache::forget('collections.navigation');
        if(!Cache::has('collections.navigation')){
            Cache::forever('collections.navigation', $this->getMenuLists());
        }
        $this->navigation['lists'] = Cache::get('collections.navigation');

    }

    public function getMenuLists()
    {
        // TODO: deal with errors
        // get all items
        $items = (new ApiCollectionService)->all([
            'includes' => false
        ]);

        // turn pages into array
        $items = $items->map(function($item){
            $item = $item->toArray();
            $item['link'] = '/collections/'.$item['slug'];
            $item['label'] = $item['name'];
            $item['deletable'] = true;
            $item['action'] = '/collections';
            return $item;
        })->toArray();
        // prepare for navigation
        return [
            [
                'items' => isset($items) ? $items : [],
                'elements' => [
                    view('navigation.add', [
                        'action'    => '/collections',
                        'method'    => 'post',
                        'label'     => 'Add Collection'
                    ])->render(),
                ]
            ]
        ];
    }

    public function index(){
        $data['navigation'] = $this->buildNavigation('/collections');

        return view('collections.dashboard', $data);
    }

    public function store()
    {
        $item = (new ApiCollectionService)->create('New Collection','new-collection-'.rand());

        Cache::forget('global.collections');

        return redirect('collections/new-collection');
    }

    public function show($collection, $page = NULL)
    {

        $data['collection'] = (new ApiCollectionService)->first('slug',$collection);

        $data['page'] = $data['collection']->pages->filter(function($item) use($page){
            return $item->slug === $page;
        });

        if(($page === NULL || $data['page']->isEmpty()) && !$data['collection']->pages->isEmpty() ){
            return redirect('collections/'.$collection.'/'.$data['collection']->pages->first()->slug);
        }

        $data['page'] = $data['page']->first();

        $this->navigation = [
            'header' => [
                'title' => $data['collection']->name,
                'link' => '/collections/',
            ],
            'lists' => [
                [
                    'items' => $data['collection']->pages->map(function($item) use($collection){
                        $item = $item->toArray();
                        $item['link'] = '/collections/'.$collection.'/'.$item['slug'];
                        return $item;
                    })->toArray(),
                    'item' => 'pages.navigation-item',
                    'elements' => [
                        view('navigation.add', [
                            'action'    => '/pages',
                            'method'    => 'post',
                            'label'     => 'Add Page',
                            'fields'    => [
                                'collection'    => $data['collection']->id
                            ]
                        ])->render(),
                    ]
                ],
            ]
        ];

        if($page === NULL){
            $data['navigation'] = $this->buildNavigation('/collections/'.$collection);
            return view('collections.dashboard', $data);
        }

        $data['navigation'] = $this->buildNavigation('/collections/'.$collection.'/'.$page);

        return view('pages.page', $data);
    }
    /**
     * delete a collection
     *
     * @method delete
     */
    public function delete(Request $request)
    {
        $collection = (new ApiCollectionService)->get($request->id);
        // TODO: deal with errors
        if($collection->pages->isEmpty()){
            $response = $this->api($this->client)->delete('/collections/'.$request->id);

            Cache::forget('collections.navigation');

            return back();
        }
        return back()->with(['status' => 'You must delete all pages in a collection, before deleting the collection.','type' => 'error']);
    }

}
