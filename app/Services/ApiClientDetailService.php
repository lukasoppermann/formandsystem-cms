<?php

namespace App\Services;

use Event;
use App\Events\ClientWasDeleted;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;
use App\Models\AccountDetail;

class ApiClientDetailService extends AbstractService
{
    /**
     * create a new client
     *
     * @method create
     *
     * @return EXCEPTION|array
     */
    public function create(Account $account, $detail, $account_detail)
    {
        //TODO: migrate to use entities directly e.g. be dealt with within entities
        // get ids for client & cms client
        $cms_id = json_decode($account->accountdetails->where('type','cms_client')->first()->data, true)['client_id'];
        $client_id = json_decode($account->accountdetails->where('type','client')->first()->data, true)['client_id'];
        // post details to api & connect to clients
        $response = $this->api($this->config['cms'])->post('/details', [
            'type' => 'details',
            'attributes' => [
                'type' => $detail['type'],
                'data' => $detail['data'],
            ],
            'relationships' => [
                'ownedByClients' => [
                    'data' => [
                        [
                            "type" => "clients",
                            "id" => $cms_id,
                        ],
                        [
                            "type" => "clients",
                            "id" => $client_id,
                        ],
                    ]
                ]
            ]
        ]);
        // TODO: deal with errors
        // store detail with account
        if( !isset($response['status_code']) ){
            $newDetail = (new \App\Models\AccountDetail)->create([
                'type'  => $account_detail['type'],
                'data' => json_encode([
                    'data'      => $account_detail['data'],
                    'detail_id' => $response['data']['id'],
                ]),
            ]);
            // add new detail to db
            $account->accountdetails()->save($newDetail);
            // add new detail to cache
            config('app.user')->account()->attach(new \App\Entities\AccountDetail($newDetail));
            // return data
            return [
                'type'  => $account_detail['type'],
                'data' => $account_detail['data'],
            ];
        }
    }
    /**
     * delete a client
     *
     * @method delete
     *
     * @return true|string
     */
    public function delete(Account $account, $type){
        // delete client
        // TODO: deal with error when no data
        // get detail id
        //
        $detail = $account->accountdetails->where('type',$type)->first();

        if(isset($detail)){
            $detail_id = json_decode($detail->data, true)['detail_id'];
            // delete detail
            $response = $this->api($this->config['cms'])->delete('/details/'.$detail_id);
            // successfully deleted
            if(!isset($response['status_code']) || $response['status_code'] === 404){
                $account->accountdetails()->where('type', $type)->first()->delete();
                // remove from cache
                config('app.user')->account()->details('type',$type,true)->delete();
            }
        }
    }
}
