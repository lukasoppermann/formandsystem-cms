<?php

namespace App\Http\Controllers\Collections;

use Illuminate\Http\Request;
use Cache;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ApiCollectionService;

class Collections extends Controller
{
    protected $collections;
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
        $this->navigation['lists'] = $this->getMenuLists();
    }

    public function getMenuLists()
    {
        // TODO: deal with errors
        // get all items
        $this->collections = $items = (new ApiCollectionService)->all([
            'includes' => false
        ]);
        // turn pages into array
        $items = $items->map(function($item){
            $item = $item->toArray();
            $item['link'] = '/collections/'.$item['slug'];
            $item['label'] = $item['name'];
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


    public function show($collection, $page = NULL)
    {
        $data['collection'] = (new ApiCollectionService)->first('slug',$collection);
        $data['collections'] = $this->collections;


        if($data['collection'] === NULL){
            return redirect('collections')->with([
                'status' => 'The collection you are trying to edit does not exist',
                'type' => 'error',
            ]);
        }

        $data['dialog'] = view('collections.settings', [
            'collection' => $data['collection']
        ])->render();

        $this->navigation = [
            'header' => view('collections.collection-header', [
                'collection' => $data['collection']
            ])->render(),
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
                            'deletable' => true,
                            'fields'    => [
                                'collection'    => $data['collection']->id
                            ]
                        ])->render(),
                    ]
                ],
            ]
        ];

        $data['page'] = $data['collection']->pages->filter(function($item) use($page){
            return $item->slug === $page;
        });

        if($page === NULL){
            return $this->firstItemOrEmpty($data['collection']);
        }
        // if($page !== NULL && $data['collection']->pages->isEmpty()){
        //     return redirect('collections/'.$collection);
        // }

        if(($page === NULL || $data['page']->isEmpty()) && !$data['collection']->pages->isEmpty()){
            return redirect('collections/'.$collection.'/'.$data['collection']->pages->first()->slug);
        }


        $data['page'] = $data['page']->first();

        if($page === NULL){
            $data['navigation'] = $this->buildNavigation('/collections/'.$collection);
            return view('collections.dashboard', $data);
        }

        $data['navigation'] = $this->buildNavigation('/collections/'.$collection.'/'.$page);

        return view('pages.page', $data);
    }
    /**
     * create a collection
     *
     * @method store
     */
    public function store()
    {
        // TODO: needs refactor
        // create unique slug
        $slug = 'new-collection-'.rand();
        while(!(new ApiCollectionService)->find('slug',$slug)->isEmpty()){
            $slug = 'new-collection-'.rand();
        }

        $item = (new ApiCollectionService)->create([
            'name' => 'New Collection',
            'slug' => $slug,
        ]);

        $this->collections = (new ApiCollectionService)->all([
            'includes' => false
        ]);

        return redirect('collections/'.$slug);
    }
    /**
     * delete a collection
     *
     * @method delete
     */
    public function delete(Request $request, $id)
    {
        $collection = (new ApiCollectionService)->get($request->id);
        // TODO: deal with errors
        if($collection->pages->isEmpty()){
            $response = $this->api($this->client)->delete('/collections/'.$request->id);
            return redirect('collections');
        }
        return back()->with(['status' => 'You must delete all pages in a collection, before deleting the collection.','type' => 'error']);
    }
    /**
     * update the collection
     *
     * @method update
     *
     * @param  Request $request
     * @param  string  $id
     *
     * @return redirect
     */
    public function update(Request $request, $id)
    {

        return back()->with([
            'status' => 'Collection updated successfully.',
            'type' => 'success'
        ]);
    }
    /**
     * show the first page or the dashboard
     *
     * @method firstItemOrEmpty
     *
     * @return view
     */
    public function firstItemOrEmpty($collection)
    {
        // collection with items
        $types = [
            'pages' => 'pages.page',
            'fragments' => 'fragments.fragment',
        ];
        foreach($types as $type => $template){
            if( !$collection->{$type}->isEmpty() ){
                $data['navigation'] = $this->buildNavigation('/collections/'.$collection->slug);

                $data[substr($type,0,-1)] = $collection->{$type}->first();
                return view($template, $data);
            }
        }
        // empty collection
        $this->navigation['lists'] = NULL;
        $data['navigation'] = $this->buildNavigation('/collections/'.$collection->slug);
        return view('collections.empty', $data);
    }
}
