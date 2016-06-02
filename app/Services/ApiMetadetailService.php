<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;
use App\Entities\Metadetail;

class ApiMetadetailService extends AbstractApiService
{
    /**
     * all available includes
     *
     * @var array
     */
    protected $includes = [

    ];
    /**
     * the name of the entity
     *
     * @var string
     */
    protected $entity = '\App\Entities\Metadetail';
    /**
     * the api endpoint to connect to
     *
     * @var string
     */
    protected $endpoint = 'metadetails';
    /**
     * get
     *
     * @method find
     *
     * @param  array $keys
     *
     * @return App\Entities\Metadetail
     */
    public function findMany(Array $keys)
    {
        // API CALL
        $metadetails = $this->getAllItems('/metadetails?filter[type]='.implode(',',$keys));
        // build result array
        $entities = [];
        foreach($metadetails['data'] as $detail){
            $entities[] = new Metadetail($detail, !isset($metadetails['included']) ?: $metadetails['included']);
        }
        // return
        return $entities;
    }

    /**
     * store
     *
     * @method store
     *
     * @return EXCEPTION|array
     */
    public function storeMany(Array $details){
        // prepare details = json_encode if value is array
        $details = array_map(function($item){
            if(is_array($item)){
                return json_encode($item);
            }
            return $item;
        }, $details);

        // loop  all details
        foreach($details as $type => $data){
            // TODO: handle errors
            // make api call
            $response = $this->api($this->client)->post('/metadetails', [
                'type' => 'metadetails',
                'attributes' => [
                    'type' => $type,
                    'data' => $data,
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
    public function updateMany(Array $details, $request_input_ids = []){
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
        foreach($details as $type => $data){
            // TODO: handle errors
            if(isset($request_input_ids[$type.'_id'])){
                if(trim($data) === ""){
                    return $this->api($this->client)->delete('/metadetails/'.$request_input_ids[$type.'_id']);
                }
                // make api call
                $response = $this->api($this->client)->patch('/metadetails/'.$request_input_ids[$type.'_id'], [
                    'id' => $request_input_ids[$type.'_id'],
                    'type' => 'metadetails',
                    'attributes' => [
                        'type' => $type,
                        'data' => $data,
                    ]
                ]);
            }else{
                // make api call
                $response = $this->api($this->client)->post('/metadetails', [
                    'type' => 'metadetails',
                    'attributes' => [
                        'type' => $type,
                        'data' => $data,
                    ]
                ]);
            }
        }
    }

    public function update($id, Array $data){
        // TODO: handle errors
        // make api call
        $response = $this->api($this->client)->patch('/'.$this->endpoint.'/'.$id, [
            'type' => $this->endpoint,
            'id'   => $id,
            'attributes' => $data,
        ]);

        return $response;
    }
    /**
     * store
     *
     * @method store
     *
     * @return EXCEPTION|array
     */
    public function store(Array $data){
        // TODO: handle errors
        // make api call
        $response = $this->api($this->client)->post('/'.$this->endpoint, [
            'type' => $this->endpoint,
            'attributes' => $data,
        ]);

        return $response;
    }
}
