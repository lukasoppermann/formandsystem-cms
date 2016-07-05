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
use App\Entities\Page;
use Illuminate\Support\Collection as LaravelCollection;

class Pages extends Controller
{
    /**
     * collections
     */
    protected $collections;

    public function index(){
        return view('pages.dashboard');
    }

    public function show($slug)
    {
        $page = NULL;
        foreach(config('app.user')->account()->navigation() as $collection){
            if( $new_page = $collection->pages()->where('slug', $slug)){
                $page = $new_page->first();
            }
        }

        if($page === NULL){
            return redirect('/pages');
        }

        return view('pages.page', [
            'item'          => $page,
            'collection'    => $page->parentCollection(),
            'collections'   => $page->collections('type','posts'),
        ]);
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
            'published'  => true,
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
            $collection = config('app.user')->account()->navigation()->first();
        }else{
            $collection = $collection->get('collection');
            $collection = new \App\Entities\Collection($collection);
        }
        // create new page
        $newPage = (new \App\Entities\Page($page->toArray()));
        // attach to collection
        $collection->attach($newPage);

        if($collection->get('type') === 'navigation'){
            return redirect('pages/'.$newPage->get('slug'));
        }

        return redirect('collections/'.$collection->get('slug').'/'.$newPage->get('slug'));
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
            $deleted = (new \App\Entities\Page($id))->delete();
        }
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
        // get validated data
        $data = $this->getValidated($request, [
            'id'                => 'required|string',
            'menu_label'        => 'required|string',
            'slug'              => 'required|alpha_dash',
            'title'             => 'required|string',
            'description'       => 'required|string',
            'collection'        => 'required|string',
        ]);
        // if validation fails
        if($data->get('isInvalid')){
            return back()
                ->with(['status' => 'Updating the page failed. Please check the settings section.', 'type' => 'error'])
                ->withErrors($data->get('validator'))
                ->withInput();
        }
        // store detail
        try{
            $page = config('app.user')->account()->navigation('id',$data['collection'],true)->pages('id',$data['id'],true);
            $page->update((new LaravelCollection($data))->except(['collection','id'])->toArray());

            // redirect on success
            return redirect('/'.$page->parentCollection()->get('slug').'/'.$page->get('slug'))->with([
                'status' => 'This page has been updated successfully.',
                'type' => 'success'
            ]);
        // ERROR
        }catch(Exception $e){
            \Log::error($e);
            return back()->with(['status' => 'Saving this page failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
        }
    }
}
