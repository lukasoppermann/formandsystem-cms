<?php

namespace App\Http\Controllers\Collections;


use App\Http\Requests;
use Cache;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Services\Api\CollectionService;

class Collections extends Controller
{
    /**
     * collection dashboard
     *
     * @method index
     *
     * @return View
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
            return redirect('/')->with([
                'status' => 'The collection you are trying to edit does not exist',
                'type' => 'error',
            ]);
        }
        // if no page was set redirect to first page or empty page
        if($page === NULL){
            return $this->firstItemOrEmpty($collection);
        }
        // --------------------------
        // BUILD NAVIGATION
        // get pages
        if(!$collection->pages->isEmpty()){
            $content_type = 'pages';
            $items = $collection->pages->map(function($item) use ($collection){
                return $item->put('link', '/collections/'.$collection->slug.'/'.$item->slug);
            });
        }
        // get fragments
        if(!$collection->fragments->isEmpty()){
            $content_type = 'fragments';
            $items = $collection->fragments->map(function($item) use ($collection){
                return $item->put('link', '/collections/'.$collection->slug.'/'.$item->id);
            });
        }
        // -------------------------
        // if pages collection
        if($content_type === 'pages'){
            // get item
            $item = $collection->pages->filter(function($item) use ($page){
                return $item->slug === $page;
            })->first();
            // show item if exists
            if(!$item->isEmpty()){
                return view('pages.page', [
                    'dialog' => view('collections.settings', [
                            'collection' => $collection,
                        ])->render(),
                    'item' => $item,
                    'collection' => $collection,
                ]);
            }
        }
        // -------------------------
        // if fragments collection
        if($content_type === 'fragments'){
            // get item
            $item = $collection->fragments->filter(function($item) use ($page){
                return $item->id === $page;
            })->first();
            // show item if exists
            if(!$item->isEmpty()){
                return view('collections.fragment', [
                    'dialog' => view('fragments.settings', [
                        ])->render(),
                    'item' => $item,
                    'collection' => $collection,
                ]);
            }
        }
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
    public function firstItemOrEmpty($collection)
    {
        $items_types = [
            'pages' => 'slug',
            'fragments' => 'id',
        ];
        // collection with items
        foreach($items_types as $type => $slug){
            if( !$collection->{$type}->isEmpty() ){
                return redirect('collections/'.$collection->slug.'/'.$collection->{$type}->first()->{$slug});
            }
        }
        // if collection is empty
        return view('collections.empty', [
            'collection' => $collection
        ]);
    }
}
