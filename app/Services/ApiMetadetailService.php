<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;

class ApiMetadetailService extends AbstractService
{
    /**
     * get
     *
     * @method get
     *
     * @param  array $key [description]
     *
     * @return array
     */
    public function get(Array $keys)
    {
        // get all details
        $details = [];
        $this->getWhileNext($details, '/metadetails?filter[type]='.implode(',',$keys));
        // prepare
        $details = array_map(function($item){
            return [
                'id'             => $item['id'],
                'resource_type'  => $item['type'],
                'type'           => $item['attributes']['type'],
                'value'          => $item['attributes']['value'],
            ];
        }, $details);
        // return details
        return $details;
    }

    protected function getWhileNext(&$details, $url)
    {
        $response = $this->api($this->client)->get($url);

        $details = array_merge(array_values($details), array_values($response['data']));

        if( isset($response['meta']['pagination']['links']['next']) ){
            $this->getWhileNext($details, $response['meta']['pagination']['links']['next']);
        }
    }
    /**
     * store
     *
     * @method store
     *
     * @return EXCEPTION|array
     */
    public function store(Array $details){
        // prepare details = json_encode if value is array
        $details = array_map(function($item){
            if(is_array($item)){
                return json_encode($item);
            }
            return $item;
        }, $details);

        // loop  all details
        foreach($details as $type => $value){
            // TODO: handle errors
            // make api call
            $response = $this->api($this->client)->post('/metadetails', [
                'type' => 'metadetails',
                'attributes' => [
                    'type' => $type,
                    'value' => $value,
                ]
            ]);
        }
    }
    /**
     * update or create
     *
     * @method update
     *
     * @return EXCEPTION|array
     */
    public function update(Array $details, $request_input_ids = []){
        // remove empty requests
        $request_input_ids = array_filter($request_input_ids);
        // prepare details = json_encode if value is array
        $details = array_map(function($item){
            if(is_array($item)){
                return json_encode($item);
            }
            return $item;
        }, $details);

        // loop  all details
        foreach($details as $type => $value){
            // TODO: handle errors
            if(isset($request_input_ids[$type.'_id'])){
                if(trim($value) === ""){
                    return $this->api($this->client)->delete('/metadetails/'.$request_input_ids[$type.'_id']);
                }
                // make api call
                $response = $this->api($this->client)->patch('/metadetails/'.$request_input_ids[$type.'_id'], [
                    'id' => $request_input_ids[$type.'_id'],
                    'type' => 'metadetails',
                    'attributes' => [
                        'type' => $type,
                        'value' => $value,
                    ]
                ]);
            }else{
                // make api call
                $response = $this->api($this->client)->post('/metadetails', [
                    'type' => 'metadetails',
                    'attributes' => [
                        'type' => $type,
                        'value' => $value,
                    ]
                ]);
            }
        }
    }
}
