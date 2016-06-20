<?php

namespace App\Http\Controllers\Fragments;

use App\Services\Api\PageService;
use App\Services\Api\CollectionService;
use App\Services\Api\MetadetailService;
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
            (new PageService)->clearCache();
        }

        if($item = $request->get('fragment')){
            $response =
                $this->api($this->client)->post('/fragments/'.$fragment['data']['id'].'/relationships/ownedByFragments', [
                    'type' => 'fragments',
                    'id'   => $item,
            ]);
            (new FragmentService)->clearCache();
            (new PageService)->clearCache();
        }

        if($item = $request->get('collection')){
            $response =
                $this->api($this->client)->post('/fragments/'.$fragment['data']['id'].'/relationships/ownedByCollections', [
                    'type' => 'collections',
                    'id'   => $item,
            ]);
            (new CollectionService)->clearCache();
        }
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
            // get & delete connected images
            foreach((new FragmentService)->get($id)->images as $image){
                $this->api($this->client)->delete('/images/'.$image->id);
            }

            $response = (new FragmentService)->delete($id);
            // clear cache
            (new CollectionService)->clearCache();
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
        // // transform input
        // $request->replace(
        //     array_merge(
        //         $request->only([
        //             'columns_medium',
        //             'columns_small',
        //             'columns_large',
        //             'classes',
        //             'data',
        //             'collection',
        //         ]),
        //         [
        //             'columns_medium' => $request->get('columns_medium') === NULL ? config('user.grid-md') : $request->get('columns_medium'),
        //             'columns_small' => $request->get('columns_small') === NULL ? config('user.grid-sm') : $request->get('columns_small'),
        //             'columns_large' => $request->get('columns_large') === NULL ? config('user.grid-lg') : $request->get('columns_large'),
        //         ]
        //     )
        // );
        // validate input
        //  $validator = Validator::make($request->all(), [
        //     'data'              => 'string',
        //     'collection'        => 'string',
        // ]);
        // if validation fails
        // if($validator->fails()){
        //     return back()
        //         ->with(['status' => 'Updating the fragment failed.', 'type' => 'error'])
        //         ->withErrors($validator, $id)
        //         ->withInput();
        // }
        // get current fragment
        $fragment = (new FragmentService)->get($id, [
            'includes' => [
                'ownedByPages',
                'ownedByCollections',
                'ownedByFragments',
            ]
        ]);
        // update the details for the current fragment
        $this->updateFragmentDetails($request, $fragment);
        // update the fragment data
        $this->updateFragment($request, $id, $fragment);
        // clear cache
        if(!$fragment->ownedByPages->isEmpty()){
            (new PageService)->clearCache();
        }
        if(!$fragment->ownedByCollections->isEmpty()){
            (new CollectionService)->clearCache();
        }
        if(!$fragment->ownedByFragments->isEmpty()){
            (new PageService)->clearCache();
            (new CollectionService)->clearCache();
            (new FragmentService)->clearCache();
        }
        // redirect on success
        return back()->with([
            'status' => 'This fragment has been updated successfully.',
            'type' => 'success'
        ]);
        // }catch(Exception $e){
        //     \Log::error($e);
        //
            // return back()->with(['status' => 'Saving this fragment failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
        // }
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
            'columns_medium' => $request->get('columns_medium') === NULL ? config('user.grid-md') : $request->get('columns_medium'),
            'columns_small' => $request->get('columns_small') === NULL ? config('user.grid-sm') : $request->get('columns_small'),
            'columns_large' => $request->get('columns_large') === NULL ? config('user.grid-lg') : $request->get('columns_large'),
        ]);
        // if validation fails
        if($details->get('isInvalid')){
            return back()
                ->with(['status' => 'Updating the fragment failed.', 'type' => 'error'])
                ->withErrors($details->get('validator'), $id)
                ->withInput();
        }
        // store detail
        try{
            foreach($details as $key => $value){
                // update or add details
                $detail = $fragment->metadetails->filter(function($item) use($key){
                    return $item->type === $key;
                })->first();
                if($detail !== NULL && $detail->data !== $value){
                    (new MetadetailService)->update(
                        $detail->id,
                        [
                            'type' => $key,
                            'data' => $value,
                        ]
                    );
                } elseif($detail === NULL) {
                    $detail = (new MetadetailService)->create(
                        [
                            'type' => $key,
                            'data' => $value,
                        ]
                    );
                    $response = $this->api($this->client)->post('/fragments/'.$fragment->id.'/relationships/metadetails', [
                        'type' => 'metadetails',
                        'id'   => $detail['data']['id'],
                    ]);
                }
            }
        }
        catch(Exception $e){
            \Log::error($e);

            return back()->with(['status' => 'Saving this fragment failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
        }
    }
    /**
     * update the given fragment
     *
     * @method updateFragment
     *
     * @param  Request               $request  [description]
     * @param  Entity                $fragment [description]
     *
     * @return [type]
     */
    protected function updateFragment(Request $request, $id, $fragment)
    {
        // get collection data
        $data = $this->getValidated($request, [
            'collection' => 'string',
            'data'       => 'string',
        ]);
        // update data
        if( $data->get('data') !== NULL ){
            $fragment = (new FragmentService)->update($id,
                [
                    'type' => $fragment->type,
                    'name' => $fragment->name,
                    'data' => $data->get('data'),
                ]
            );
        }
        // update collection
        if( $data->get('collection') !== NULL ){
            $response = $this->api($this->client)->patch('/fragments/'.$fragment->id.'/relationships/collections', [
                'type' => 'collections',
                'id'   => $data->get('collection'),
            ]);
        }
    }
}
