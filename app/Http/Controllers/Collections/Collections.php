<?php

namespace App\Http\Controllers\Collections;


use App\Http\Requests;
use Cache;
use App\Services\Api\PageService;
use App\Services\Api\FragmentService;
use App\Services\Api\MetadetailService;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                return $item->put('link', '/collections/'.$collection->slug.'/'.$item->slug);
            });
        }
        // get fragments
        if(!$collection->fragments()->isEmpty()){
            $content_type = 'fragments';
            $items = $collection->fragments()->map(function($item) use ($collection){
                return $item->put('link', '/collections/'.$collection->slug.'/'.$item->id);
            });
        }
        // -------------------------
        // if pages collection
        if(isset($content_type) && $content_type === 'pages'){
            // get item
            $item = $collection->pages->filter(function($item) use ($page){
                return $item->slug === $page;
            })->first();
            // show item if exists
            if($item !== NULL){
                return view('pages.page', [
                    // 'dialog' => view('collections.settings', [
                    //         'collection' => $collection,
                    //     ])->render(),
                    'item' => $item,
                    'collection' => $collection,
                ]);
            }
        }
        // -------------------------
        // if fragments collection
        if(isset($content_type) && $content_type === 'fragments'){
            // show item if exists
            if(!$collection->fragments->isEmpty()){
                return view('collections.fragments', [
                    'items'         => $collection->fragments,
                    'collection'    => $collection,
                    'collections'   => (new CollectionService)->find('type','posts'),
                    'fragment'      => config('app.account')->details->where('type', 'fragment')->where('name',$collection->fragments->first()->type)->first()->data,
                    'elements'      => [
                        view('fragments.add-custom-fragment', [
                            'collection' => $collection,
                            'type'       => $collection->fragments->first()->type,
                        ])->render()
                    ]
                ]);
            }
        }
        if($page === NULL){
            return $this->firstItemOrEmpty($collection);
        }

        return redirect('/collections/'.$collection->slug);
        // return redirect('/');
    }
    /**
     * create a collection
     *
     * @method store
     */
    public function store(Request $request)
    {
        $slugs = (new CollectionService)->find('type','posts',[
            'only' => false
        ])->pluck('slug')->toArray();
        // get page data
        $item = $this->getValidated($request, [
            'name'      => 'required|string',
            'slug'      => 'required|alpha_dash|not_in:'.implode(',',$slugs),
            'type'      => 'required|in:pages,news',
        ]);

        // if validation fails
        if($item->get('isInvalid')){
            return back()->with([
                'status'            => 'Creating collection failed: '.implode(' ',$item->get('validator')->errors()->all()),
                'type'              => 'error',
            ])->withErrors($item->get('validator'))
            ->withInput();
        }
        $response = (new CollectionService)->create([
            'name' => $item->get('name'),
            'slug' => strtolower($item->get('slug')),
            'type' => 'posts',
        ]);
        // if invalid response
        if(isset($response['errors'])){
            $errors = "";
            foreach($response['errors'] as $msg){
                $errors .= implode(' ',$msg);
            }
            return back()->with(['status' => 'Update failed: '.$errors,'type' => 'error']);
        }

        if($item->get('type') === 'pages'){
            $newPage = (new PageService)->create([
                'menu_label'    => 'New Page',
                'slug'          => $item->get('slug').'-new-page',
                'language'      => 'de',
                'published'     => true,
            ]);

            $rel = $this->api(config('app.user_client'))->post('/collections/'.$response['data']['id'].'/relationships/pages', [
                'type' => 'pages',
                'id'   => $newPage['data']['id'],
            ]);
        }

        if($item->get('type') === 'news'){
            $new = (new FragmentService)->create([
                'type'    => 'news',
            ]);

            $rel = $this->api(config('app.user_client'))->post('/collections/'.$response['data']['id'].'/relationships/fragments', [
                'type' => 'fragments',
                'id'   => $new['data']['id'],
            ]);
        }

        return redirect('collections/'.$item->get('slug'));
    }
    /**
     * delete a collection
     *
     * @method delete
     */
    public function delete(Request $request, $id)
    {
        $collection = (new CollectionService)->find('id',$request->id);
        // TODO: deal with errors
        if($collection->pages->isEmpty() && $collection->fragments->isEmpty()){
            $response = (new CollectionService)->delete($request->id);
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
        $response = (new CollectionService)->update($id, [
            'type' => 'posts',
            'name' => $item->get('name'),
            'slug' => $item->get('slug'),
        ]);
        // if invalid response
        if(isset($response['errors'])){
            $errors = "";
            foreach($response['errors'] as $msg){
                $errors .= implode(' ',$msg);
            }
            return back()->with(['status' => 'Update failed: '.$errors,'type' => 'error']);
        }

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
            if( !$collection->{$type}()->isEmpty() ){
                return redirect('collections/'.$collection->slug.'/'.$collection->{$type}->first()->{$slug});
            }
        }
        // if collection is empty
        return view('collections.empty', [
            'collection' => $collection
        ]);
    }
}
