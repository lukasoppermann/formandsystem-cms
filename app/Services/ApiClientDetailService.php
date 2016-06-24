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
        // get ids for client & cms client
        $cms_id = json_decode($account->details->where('type','cms_client')->first()->data, true)['client_id'];
        $client_id = json_decode($account->details->where('type','client')->first()->data, true)['client_id'];
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
        // dd($response);
        // TODO: deal with errors
        // store detail with account
        if( !isset($response['status_code']) ){
            $account->details()->save((new \App\Models\AccountDetail)->create([
                'type'  => $account_detail['type'],
                'data' => json_encode([
                    'data'      => $account_detail['data'],
                    'detail_id' => $response['data']['id'],
                ]),
            ]));
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
        $detail = $account->details->where('type',$type)->first();

        if(isset($detail)){
            $detail_id = json_decode($detail->data, true)['detail_id'];
            // delete detail
            $response = $this->api($this->config['cms'])->delete('/details/'.$detail_id);
            // successfully deleted
            if(!isset($response['status_code']) || $response['status_code'] === 404){
                $account->details()->where('type', $type)->first()->delete();
            }
        }
    }
}
