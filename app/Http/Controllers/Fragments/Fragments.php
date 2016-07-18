<?php

namespace App\Http\Controllers\Fragments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Fragment;
use App\Entities\Collection;
use Validator;

class Fragments extends Controller
{
    /**
     * define which fragment types are defaults
     */
    protected $default_fragments = [
        'section',
        'image',
        'text',
        'dropdown',
        'input',
        'button',
        'collection',
    ];

    public function store(Request $request)
    {
        // get parent entity
        $parentEntity = '\App\Entities\\'.ucfirst($request->get('parentType'));
        $parentEntity = new $parentEntity($request->get('parentId'));
        // get position
        $position = $parentEntity->fragments()->count() + 1;
        // CUSTOM ELEMENT
        if( !in_array($request->get('type'), $this->default_fragments) ){

            $blueprint = config('app.user')->account()->details('type','fragment')->where('name',$request->get('type'))->first();

            if( $blueprint === null ){
                return back();
            }
            // get add meta

            $meta = NULL;
            if(isset($blueprint['data']['meta']) && isset($blueprint['data']['meta']['meta'])){
                $meta = $blueprint['data']['meta']['meta'];
            }
            // create new element
            $fragment = new \App\Entities\Fragment([
                'type'      => $request->get('type'),
                'data'      => json_encode($blueprint['data']),
                'position'  => $position,
                'meta'      => $meta
            ]);
            // create subelements
            $this->newCustomFragment($fragment, $blueprint);
        // NORMAL ELEMENT
        }else {
            $fragment = new \App\Entities\Fragment([
                'type' => $request->get('type'),
                'position'  => $position,
            ]);
        }
        // attach fragment to parent
        $parentEntity->attach($fragment);
        // redirect back
        return back();
    }
    /**
     * delete a page
     *
     * @method delete
     */
    public function delete(Request $request, $id = NULL)
    {
        // TODO: deal with errors
        if($id !== NULL){
            // get fragment
            $fragment = new \App\Entities\Fragment($id);
            // delete image connections
            foreach($fragment->images() as $image){
                $image->delete();
            }
            // delete element
            $deleted = $fragment->delete();
        }

        return back();
    }
    /**
     * update a page
     *
     * @method update
     */
    public function update(Request $request, $id)
    {
        // get fragment
        $fragment = new \App\Entities\Fragment($id);
        // update position ?
        if($request->json('position') !== NULL){
            return $fragment->update([
                'position'  => $request->json('position'),
            ]);
        }
        // add collection
        if($request->has('collection')){
            $fragment->detachAll('collections');
            // attach new collection
            if($request->get('collection') !== NULL){
                $fragment->attach(new Collection($request->get('collection')));
            }
        }
        // update other data
        if($request->json('data')){
            $data = $request->json('data') !== '$undefined' ? $request->json('data') : NULL;
            return $fragment->update([
                'data'  => $data,
            ]);
        }
        // update the details for the current fragment
        $this->updateFragmentDetails($request, $fragment);
        // update the fragment data
        $data = $this->getValidated($request, [
            'data'       => 'string'
        ]);
        // update data
        if( $data->get('data') !== NULL ){
            $fragment->update([
                'data'      => $data->get('data'),
            ]);
        }
        // redirect on success
        return back()->with([
            'status' => 'The fragment has been updated successfully.',
            'type' => 'success'
        ]);
    }
    /**
     * update the details of a given fragment
     *
     * @method updateFragmentDetails
     *
     * @param  Request               $request  [description]
     * @param  Entity                $fragment [description]
     *
     * @return [type]
     */
    protected function updateFragmentDetails(Request $request, $fragment)
    {
        // get details data
        $details = $this->getValidated($request, [
            'columns.sm'        => 'in:'.implode(',',range(0, config('user.grid-sm'))),
            'columns.md'        => 'in:'.implode(',',range(0, config('user.grid-md'))),
            'columns.lg'        => 'in:'.implode(',',range(0, config('user.grid-lg'))),
            'custom_classes'    => 'string',
        ]);

        // if validation fails
        if($details->get('isInvalid')){
            return back()
                ->with(['status' => 'Updating the fragment failed.', 'type' => 'error'])
                ->withErrors($details->get('validator'), $fragment->get('id'))
                ->withInput();
        }
        // store detail
        try{
            $fragment->update([
                'meta' => array_merge((array)$fragment->get('meta'), $details->toArray())
            ]);
        }
        catch(Exception $e){
            \Log::error($e);

            return back()->with(['status' => 'Saving this fragment failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
        }
    }
    /**
     * create a custom fragment and all subfragments
     *
     * @method newCustomFragment
     *
     * @param  App\Entities\AbstractEntity      $parent [description]
     * @param  string                           $type [description]
     *
     * @return model
     */
    protected function newCustomFragment(\App\Entities\AbstractEntity $parent, $blueprint)
    {
        // add subfragments
        foreach($blueprint['data']['elements'] as $position => $element){
            // create fragment
            $subfragment = new \App\Entities\Fragment([
                'type'      => $element['type'],
                'name'      => $element['name'],
                'position'  => $position,
                'meta'      => isset($element['meta']) ? $element['meta'] : NULL,
            ]);
            // attach to parent
            $parent->attach($subfragment);
        }
    }
}
