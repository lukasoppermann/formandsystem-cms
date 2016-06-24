<?php

namespace App\Services;

use Event;
use App\Events\ClientWasDeleted;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Account;
use App\Models\AccountDetail;

class ApiClientService extends AbstractService
{
    /**
     * create a new client
     *
     * @method create
     *
     * @return EXCEPTION|array
     */
    public function create(Account $account){
        // generate clients
        if( ! $clients = $this->generateApiAccess($account->name) ){
            throw new \Exception("Creating API token failes");
        }
        // store client to account
        $account->details()->save((new AccountDetail)->create([
            'type'  => 'client',
            'data' => json_encode([
                'client_id'     => $clients['client']['client_id'],
                'client_secret' => $clients['client']['client_secret'],
            ])
        ]));
        // store cms client to account
        $account->details()->save((new AccountDetail)->create([
            'type'  => 'cms_client',
            'data' => json_encode([
                'client_id'     => $clients['cms']['client_id'],
                'client_secret' => $clients['cms']['client_secret'],
            ])
        ]));
        // TODO: deal with errors
        // TODO: add logging
        // return client
        return $clients['client'];

    }
    /**
     * delete a client
     *
     * @method delete
     *
     * @return true|string
     */
    public function delete(Account $account){
        // delete client
        // TODO: deal with error when no data
        // get client & client id
        $detail = $account->details->where('type','client')->first();
        $client_id = json_decode($detail->data, true)['client_id'];
        // delete client connection to account
        $detail->delete();
        $account->details()->detach($detail->id);
        // delete client from api
        $client = $this->api($this->config['cms'])->delete('/clients/'.$client_id);

        // delete cms client
        // TODO: deal with error when no data
        // get client & client id
        $detail = $account->details->where('type','cms_client')->first();
        $cms_client_id = json_decode($detail->data, true)['client_id'];
        // delete client connection to account
        $detail->delete();
        $account->details()->detach($detail->id);
        // delete client from api
        $cms_client = $this->api($this->config['cms'])->delete('/clients/'.$cms_client_id);
        // on success
        if(!isset($cms_client['message']) && !isset($client['message'])){
            // fire event
            Event::fire(new ClientWasDeleted($account));
            // redirect to show
            return true;
        }
    }
    /**
     * generate the api clients
     *
     * @method generateApiAccess
     *
     * @param  string            $name
     *
     * @return array
     */
    public function generateApiAccess($name){
        // get new client
        // TODO: deal with errors
        $client = $this->api($this->config['cms'])->post('/clients', [
            'type' => 'clients',
            'attributes' => [
                'name' => $name,
                'scopes' => 'content.get',
            ]
        ]);
        // get new cms client
        $cms = $this->api($this->config['cms'])->post('/clients', [
            'type' => 'clients',
            'attributes' => [
                'name' => '[cms] '.$name,
                'scopes' => 'content.get,content.post,content.patch,content.delete',
            ]
        ]);
        if( isset($client['data']) && isset($cms['data']) ){
            // return client and cms client
            return [
                'client' => [
                    'client_id'     => $client['data']['id'],
                    'client_secret' => $client['data']['attributes']['secret'],
                ],
                'cms' => [
                    'client_id'     => $cms['data']['id'],
                    'client_secret' => $cms['data']['attributes']['secret'],
                ],
            ];
        }
        return false;
    }
}
