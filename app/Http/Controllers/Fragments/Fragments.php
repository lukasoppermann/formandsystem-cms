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

    public function store(Request $request)
    {
        // get parent entity
        $parentEntity = '\App\Entities\\'.ucfirst($request->get('parentType'));
        $parentEntity = new $parentEntity($request->get('parentId'));
        // get position
        $position = $parentEntity->fragments()->count() + 1;
        // create new entity
        $fragment = new \App\Entities\Fragment([
            'type' => $request->get('type'),
            'position'  => $position,
        ]);
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
                try{
                    $fragment->attach(new Collection($request->get('collection')));
                }catch(\App\Exceptions\EmptyException $e){

                }
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
}
