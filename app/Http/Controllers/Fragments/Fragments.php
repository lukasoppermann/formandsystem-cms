<?php

namespace App\Http\Controllers\Fragments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Fragment;
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
        'button'
    ];

    public function store(Request $request)
    {
        // CUSTOM ELEMENT
        if( !in_array($request->get('type'), $this->default_fragments) ){
            if( !isset(config('custom.fragments')[$request->get('type')]) ){
                return back();
            }
            // create new element
            $fragment = new \App\Entities\Fragment([
                'type' => $request->get('type'),
                'data' => json_encode(config('custom.fragments')[$request->get('type')]->get('data')),
            ]);
            // create subelements
            $this->newCustomFragment($fragment, $request->get('type'));
        // NORMAL ELEMENR
        }else {
            $fragment = new \App\Entities\Fragment([
                'type' => $request->get('type')
            ]);
        }
        // attach fragment
        $parentEntity = '\App\Entities\\'.ucfirst($request->get('parentType'));
        (new $parentEntity($request->get('parentId')))->attach($fragment);
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
        $fragment = new \App\Entities\Fragment($id);
        // update the details for the current fragment
        $this->updateFragmentDetails($request, $fragment);
        // update the fragment data
        $data = $this->getValidated($request, [
            'data'       => 'string',
        ]);
        // update data
        if( $data->get('data') !== NULL ){
            $fragment->update([
                'data' => $data->get('data'),
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
            'columns_small'     => 'in:'.implode(',',range(0, config('user.grid-sm'))),
            'columns_medium'    => 'in:'.implode(',',range(0, config('user.grid-md'))),
            'columns_large'     => 'in:'.implode(',',range(0, config('user.grid-lg'))),
            'classes'           => 'string',
        ], [
            'columns_medium' => config('user.grid-md'),
            'columns_small' => config('user.grid-sm'),
            'columns_large' => config('user.grid-lg'),
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
            foreach(['columns_small','columns_medium','columns_large','classes'] as $type){
                // get detail
                $detail = $fragment->metadetails('type',$type,true);
                // update
                if( !$detail->isEmpty() && isset($details[$type])){
                    $detail->update([
                        'data' => $details[$type]
                    ]);
                }
                // delete
                elseif(!$detail->isEmpty() && !isset($details[$type])){
                    $detail->delete();
                }
                // create
                elseif( isset($details[$type]) ){
                    $fragment->attach(new \App\Entities\Metadetail([
                        'type' => $type,
                        'data' => (string) $details[$type],
                    ]));
                }
            }
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
    protected function newCustomFragment(\App\Entities\AbstractEntity $parent, $type = NULL)
    {
        // get custom fragment blueprint
        $blueprint = config('app.account')->details('type','fragment')->where('name', $type)->first()->get('data');
        // add hidden css
        // somehow the classes for the element defined by the developer must be added
        // add subfragments
        foreach($blueprint['elements'] as $name => $element){
            // create fragment
            $subfragment = new \App\Entities\Fragment([
                'type' => $element['type'],
                'name' => $element['name'],
            ]);
            // attach to parent
            $parent->attach($subfragment);
        }
    }
}
