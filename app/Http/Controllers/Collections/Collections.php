<?php

namespace App\Http\Controllers\Collections;

use Illuminate\Http\Request;
use Cache;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Api\CollectionService;

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

    public function getMenu()
    {
        // TODO: deal with errors
        // get all items
        $items = (new CollectionService)->find('type', 'posts',[
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
        $this->navigation['lists'] = [
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
    /**
     * collection dashboard
     *
     * @method index
     *
     * @return [type]
     */
    public function index(){
        return view('collections.dashboard');
    }

    /**
     * show collection
     *
     * @method show
     *
     * @param  string $collection [description]
     * @param  string $page       [description]
     *
     * @return View
     */
    public function show($collection, $page = NULL)
    {
        // get collection
        if(($collection = (new CollectionService)->first('slug',$collection)) === NULL){
            return redirect('collections')->with([
                'status' => 'The collection you are trying to edit does not exist',
                'type' => 'error',
            ]);
        }
        // check if collection is empty
        if($collection->pages->isEmpty() && $collection->fragments->isEmpty()){
            return view('collections.empty', [
                'collection' => $collection
            ]);
        }
        // get pages
        if(!$collection->pages->isEmpty()){
            $type = 'pages';
            $slug = 'slug';
            $items = $collection->{$type}->map(function($item) use ($collection, $type, $slug){
                // $item = $item->toArray();
                // $item->put('link','test');
                $item->put('link', '/collections/'.$collection->slug.'/'.$item->{$slug});
                return $item;
            });
        }
        dd($items);
        // get fragments
        if(!$collection->pages->isEmpty()){

        }


        if(!$data['collection']->pages->isEmpty()){
            $type = 'pages';
            $items = $data['collection']->pages->map(function($item) use($collection){
                $item = $item->toArray();
                $item['link'] = '/collections/'.$collection.'/'.$item['slug'];
                return $item;
            })->toArray();
        }else if(!$data['collection']->fragments->isEmpty()){
            $type = 'fragments';
            $items = $data['collection']->fragments->map(function($item) use($collection){
                $item = $item->toArray();
                $item['link'] = '/collections/'.$collection.'/'.$item['id'];
                $created = Carbon::parse($item['created_at'])->format('d.m.Y');
                $item['label'] = ucfirst($item['type']).' '.$created;
                return $item;
            })->toArray();
        }

        $data['collections'] = (new CollectionService)->find('type', 'posts',[
            'includes' => false
        ]);

        $this->navigation = [
            'header' => view('collections.collection-header', [
                'collection' => $data['collection']
            ])->render(),
            'lists' => [
                [
                    'items' => $items,
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

        if($data['page']->isEmpty()){
            return $this->firstItemOrEmpty($data['collection'], $data, $type);
        }

        if(($page === NULL || $data['page']->isEmpty()) && !$data['collection']->pages->isEmpty()){
            return redirect('collections/'.$collection.'/'.$data['collection']->pages->first()->slug);
        }

        $data['page'] = $data['page']->first();

        $data['navigation'] = $this->buildNavigation('/collections/'.$collection.'/'.$page);

        return view('pages.page', [
            'dialog' => view('collections.settings', [
                    'collection' => $collection
                ])->render(),

        ]);
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
        while(!(new CollectionService)->find('slug',$slug)->isEmpty()){
            $slug = 'new-collection-'.rand();
        }

        $item = (new CollectionService)->create([
            'name' => 'New Collection',
            'slug' => $slug,
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
        $collection = (new CollectionService)->get($request->id);
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
        // get page data
        $item = $this->getValidated($request, [
            'name'      => 'required|string',
            'slug'      => 'required|string',
        ]);
        // if validation fails
        if($item->get('isInvalid')){
            return back()->with([
                'status' => 'Collection update failed.',
                'type' => 'error'
            ])->withErrors($item->get('validator'))
            ->withInput();
        }
        // if validation succeeds
        $response = (new CollectionService)->update($id, [
            'type' => 'posts',
            'name' => $item->get('name'),
            'slug' => $item->get('slug'),
        ]);

        return redirect('collections/'.$response['data']['attributes']['slug'])->with([
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
    public function firstItemOrEmpty($collection, $data)
    {
        $items_types = ['pages', 'fragments'];
        // collection with items
        foreach($items_types as $type){
            if( !$collection->{$type}->isEmpty() ){
                $data['navigation'] = $this->buildNavigation('/collections/'.$collection->slug);
                $data['collection'] = $collection;

                $data[substr($type,0,-1)] = $collection->{$type}->first();
                $slug = $data[substr($type,0,-1)]->slug;
                $slug = isset($slug) ? $slug : $data[substr($type,0,-1)]->id;
                // $data['page'] = $collection->pages->first();
                return view('collections.dashboard', $data);
                return redirect('/collections/'.$collection->slug.'/'.$slug);
            }
        }
        // empty collection
        $this->navigation['lists'] = NULL;
        $data['navigation'] = $this->buildNavigation('/collections/'.$collection->slug);
        $data['collection'] = $collection;

        return view('collections.empty', $data);
    }
}
