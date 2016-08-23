<?php

namespace App\Http\Controllers\Collections;


use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
        $collection = config('app.user')->account()->collections('slug',$collection,true);
        // get collection
        if($collection->isEmpty()){
            return redirect('/')->with([
                'status' => 'The collection you are trying to edit does not exist',
                'type' => 'error',
            ]);
        }
        // --------------------------
        // BUILD NAVIGATION
        // get pages
        if(!$collection->pages()->isEmpty()){
            // if no page was set redirect to first page or empty page
            if($page === NULL){
                return $this->firstItemOrEmpty($collection);
            }
            $content_type = 'pages';
            $items = $collection->pages()->map(function($item) use ($collection){
                return $item->put('link', '/collections/'.$collection->get('slug').'/'.$item->get('slug'));
            });
        }
        // get fragments
        if(!$collection->fragments()->isEmpty()){
            $content_type = 'fragments';
            $items = $collection->fragments()->map(function($item) use ($collection){
                return $item->put('link', '/collections/'.$collection->get('slug').'/'.$item->get('id'));
            });
        }
        // -------------------------
        // if pages collection
        if(isset($content_type) && $content_type === 'pages'){
            // get item
            $item = $collection->pages()->filter(function($item) use ($page){
                return $item->get('slug') === $page;
            })->first();
            // show item if exists
            if($item !== NULL){
                return view('pages.page', [
                    'item' => $item,
                    'collection' => $collection,
                ]);
            }
        }
        // -------------------------
        // if fragments collection
        if(isset($content_type) && $content_type === 'fragments'){
            // show item if exists
            if(!$collection->fragments()->isEmpty()){

                $fragment_blueprint = config('app.account')->details()->where('type', 'fragment')->where('name',$collection->fragments()->first()->get('type'))->first();

                if(!$fragment_blueprint->isEmpty()){
                    $elements[] = view('fragments.add-custom-fragment', [
                        'collection' => $collection,
                        'type'       => $fragment_blueprint->get('name'),
                    ])->render();
                }

                return view('collections.fragments', [
                    'items'         => $collection->fragments()->sortBy('position'),
                    'collection'    => $collection,
                    'collections'   => config('app.user')->account()->collections('type','posts'),
                    'elements'      => isset($elements) ? $elements : NULL,
                ]);
            }
        }

        if($page === NULL){
            return $this->firstItemOrEmpty($collection);
        }

        return redirect('/collections/'.$collection->get('slug'));
    }
    /**
     * create a collection
     *
     * @method store
     */
    public function store(Request $request)
    {
        $slugs = config('app.user')->account()->collections('type',['posts', 'pages', 'collections'])->implode('slug',',');
        $types = config('app.user')->account()->details('type','fragment')->reject(function($item){
           return $item['data']['meta']['available_in']['collections'] !== true;
       })->implode('name',',');

        // get page data
        $item = $this->getValidated($request, [
            'name'      => 'required|string',
            'slug'      => 'required|alpha_dash|not_in:'.$slugs,
            'type'      => 'required|in:pages,'.$types,
        ]);

        // if validation fails
        if($item->get('isInvalid')){
            return back()->with([
                'status'            => 'Creating collection failed: '.implode(' ',$item->get('validator')->errors()->all()),
                'type'              => 'error',
            ])->withErrors($item->get('validator'))
            ->withInput();
        }

        // if validation succeeds
        $collection = new \App\Entities\Collection([
            'name' => $item->get('name'),
            'slug' => strtolower($item->get('slug')),
            'type' => ($item->get('type') === 'pages' ? 'pages' : 'posts'), // TODO: needs to be refactored to acced input from form
            'position' => config('app.user')->account()->collections('type','posts')->count()+1,
        ]);
        // attach to account
        config('app.user')->account()->attachCache($collection,'AccountCollection');
        // if page collection, create new page
        if($item->get('type') === 'pages'){
            $collection->attach(new \App\Entities\Page([
                'menu_label'    => 'New Page',
                'slug'          => $item->get('slug').'-new-page',
                'language'      => 'de',
                'published'     => true,
            ]));
        }
        else{
            $collection->attach(new \App\Entities\Fragment([
                'type'    => $item->get('type'),
            ]));
        }
        // redirect to collection
        return redirect('collections/'.$collection->get('slug'));
    }
    /**
     * delete a collection
     *
     * @method delete
     */
    public function delete(Request $request, $id)
    {
        $collection = new \App\Entities\Collection($id);
        // TODO: deal with errors
        if($collection->pages()->isEmpty() && $collection->fragments()->isEmpty()){
            $response = $collection->delete();
            return redirect('/');
        }
        return back()->with(['status' => 'You must delete all items in a collection, before deleting the collection.','type' => 'error']);
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
        if($request->json('position') !== NULL){
            // get page
            $collection = config('app.user')->account()->collections('id',$id,true);
            // update position
            $collection->update([
                'position' => $request->json('position')
            ]);
            return;
        }
        // get page data
        $item = $this->getValidated($request, [
            'name'      => 'required|string',
            'slug'      => 'required|alpha_dash',
        ]);
        // if validation fails
        if($item->get('isInvalid')){
            return back()->with([
                'status'            => 'Collection update failed: '.implode(' ',$item->get('validator')->errors()->all()),
                'type'              => 'error',
            ])->withErrors($item->get('validator'))
            ->withInput();
        }
        // if validation succeeds
        $collection = (new \App\Entities\Collection($id))->update([
            'name' => $item->get('name'),
            'slug' => $item->get('slug'),
        ]);

        return redirect('collections/'.$collection->get('slug'))->with([
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
            if( !$collection->{$type}()->isEmpty() ){
                return redirect('collections/'.$collection->get('slug').'/'.$collection->{$type}()->first()->get($slug));
            }
        }
        // if collection is empty
        return view('collections.empty', [
            'collection' => $collection
        ]);
    }
}
