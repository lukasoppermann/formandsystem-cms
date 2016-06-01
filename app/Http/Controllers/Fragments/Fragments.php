<?php

namespace App\Http\Controllers\Fragments;

use App\Services\ApiMetadetailService;
use App\Services\ApiFragmentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\Fragment;
use Validator;

class Fragments extends Controller
{
    public function store(Request $request, $type)
    {
        $fragment = (new ApiFragmentService)->create(['type' => $type]);

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

        return back();
    }
    /**
     * update a page
     *
     * @method update
     */
    public function update(Request $request)
    {
        // transform input
        $request->replace(
            array_merge(
                $request->only([
                    'id',
                    'columns_medium',
                    'columns_small',
                    'columns_large',
                    'classes'
                ])
            )
        );
        // validate input
         $validator = Validator::make($request->all(), [
            'id'                => 'required|string',
            'columns_small'     => 'required|in:'.implode(',',range(0, config('user.grid-sm'))),
            'columns_medium'    => 'required|in:'.implode(',',range(0, config('user.grid-md'))),
            'columns_large'     => 'required|in:'.implode(',',range(0, config('user.grid-lg'))),
            'classes'           => 'string',
        ]);
        // if validation fails
        if($validator->fails()){
            return back()
                ->with(['status' => 'Updating the fragment failed.', 'type' => 'error'])
                ->withErrors($validator, $request->get('id'))
                ->withInput();
        }
        // get current fragment
        $fragment = (new ApiFragmentService)->get($request->id);
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
                if($create === true){
                    $item = (new ApiMetadetailService)->store(
                        [
                            'type' => $key,
                            'data' => $value,
                        ]
                    );
                    $response = $this->api($this->client)->post('/fragments/'.$fragment->id.'/relationships/metadetails', [
                        'type' => 'metadetails',
                        'id'   => $item['data']['id'],
                    ]);
                }
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
