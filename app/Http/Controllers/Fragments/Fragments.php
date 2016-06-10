<?php

namespace App\Http\Controllers\Fragments;

use App\Services\ApiMetadetailService;
use App\Services\Api\FragmentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Fragment;
use Validator;

class Fragments extends Controller
{
    public function store(Request $request)
    {
        $fragment = (new FragmentService)->create(['type' => $request->get('type')]);

        if($item = $request->get('page')){
            $response =
                $this->api($this->client)->post('/fragments/'.$fragment['data']['id'].'/relationships/ownedByPages', [
                    'type' => 'pages',
                    'id'   => $item,
            ]);
        }

        if($item = $request->get('fragment')){
            $response =
                $this->api($this->client)->post('/fragments/'.$fragment['data']['id'].'/relationships/ownedByFragments', [
                    'type' => 'fragments',
                    'id'   => $item,
            ]);
        }

        if($item = $request->get('collection')){
            $response =
                $this->api($this->client)->post('/fragments/'.$fragment['data']['id'].'/relationships/ownedByCollections', [
                    'type' => 'collections',
                    'id'   => $item,
            ]);
        }

        return back();
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
            // get & delete connected images
            foreach((new FragmentService)->get($id)->images as $image){
                $this->api($this->client)->delete('/images/'.$image->id);
            }

            $response = $this->api($this->client)->delete('/fragments/'.$id);
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
        // transform input
        $request->replace(
            array_merge(
                $request->only([
                    'columns_medium',
                    'columns_small',
                    'columns_large',
                    'classes',
                    'data',
                    'collection',
                ]),
                [
                    'columns_medium' => $request->get('columns_medium') === NULL ? config('user.grid-md') : $request->get('columns_medium'),
                    'columns_small' => $request->get('columns_small') === NULL ? config('user.grid-sm') : $request->get('columns_small'),
                    'columns_large' => $request->get('columns_large') === NULL ? config('user.grid-lg') : $request->get('columns_large'),
                ]
            )
        );
        // validate input
         $validator = Validator::make($request->all(), [
            'columns_small'     => 'in:'.implode(',',range(0, config('user.grid-sm'))),
            'columns_medium'    => 'in:'.implode(',',range(0, config('user.grid-md'))),
            'columns_large'     => 'in:'.implode(',',range(0, config('user.grid-lg'))),
            'classes'           => 'string',
            'data'              => 'string',
            'collection'        => 'string',
        ]);
        // if validation fails
        if($validator->fails()){
            return back()
                ->with(['status' => 'Updating the fragment failed.', 'type' => 'error'])
                ->withErrors($validator, $id)
                ->withInput();
        }
        // get current fragment
        $fragment = (new FragmentService)->get($id);
        // store detail
        try{
            $settings = ['columns_small','columns_medium','columns_large','classes'];
            foreach($request->only($settings) as $key => $value){
                // variable to determin creation of detail
                $create = true;

                if($fragment->metadetails !== null){
                    $detail = $fragment->metadetails->filter(function($item) use($key){
                        return $item->type === $key;
                    })->first();

                    if($detail !== NULL){
                        $create = false;
                        $item = (new ApiMetadetailService)->update(
                            $detail->id,
                            [
                                'type' => $key,
                                'data' => $value,
                            ]
                        );
                    }
                }
                // create new
                if($create === true && $value != null){
                    $item = (new ApiMetadetailService)->create(
                        [
                            'type' => $key,
                            'data' => (string)$value,
                        ]
                    );

                    $response = $this->api($this->client)->post('/fragments/'.$fragment->id.'/relationships/metadetails', [
                        'type' => 'metadetails',
                        'id'   => $item['data']['id'],
                    ]);
                }
            }

            // update data
            if( $data = $request->get('data') ){
                $fragment = (new FragmentService)->update($id,
                    [
                        'type' => $fragment->type,
                        'name' => $fragment->name,
                        'data' => $data,
                    ]
                );
            }
            // update collection
            if( $data = $request->get('collection') ){
                $response = $this->api($this->client)->patch('/fragments/'.$fragment->id.'/relationships/collections', [
                    'type' => 'collections',
                    'id'   => $request->get('collection'),
                ]);
            }
            // redirect on success
            return back()->with([
                'status' => 'This fragment has been updated successfully.',
                'type' => 'success'
            ]);
        }catch(Exception $e){
            \Log::error($e);

            return back()->with(['status' => 'Saving this fragment failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
        }
    }
}
