<?php

namespace App\Services;

use App\Entities\Account;
use App\Entities\AccountDetail;

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
        $cms_id = $account->details('type','cms_client',true)->get('data')['client_id'];
        $client_id = $account->details('type','client',true)->get('data')['client_id'];
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
            config('app.user')->account()->attach(new AccountDetail([
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
        $detail = $account->details('type',$type,true);

        if(isset($detail)){
            // delete detail
            $response = $this->api($this->config['cms'])->delete('/details/'.$detail->get('data')['detail_id']);
            // successfully deleted
            if(!isset($response['status_code']) || $response['status_code'] === 404){
                $detail->delete();
            }
        }
    }
}
