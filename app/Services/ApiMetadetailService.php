<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;

class ApiMetadetailService extends AbstractService
{
    /**
     * store
     *
     * @method store
     *
     * @return EXCEPTION|array
     */
    public function store(Array $details){
        \Log::debug(json_encode($details));
        \Log::debug(json_encode($this->client));

        foreach($details as $type => $value){

            if(is_array($value)){
                $value = json_encode($value);
            }

            $response = $this->api($this->client)->post('/metadetails', [
                'type' => 'metadetails',
                'attributes' => [
                    'type' => $type,
                    'value' => $value,
                ]
            ]);

            \Log::debug($response);
        }
    }
}
