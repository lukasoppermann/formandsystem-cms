<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Services\ApiClientService;

class Developers extends Settings
{

    public function show(Request $request){
        // store request
        $data['request'] = $request;
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/developers');
        // account
        $account = $request->user()->accounts->first();
        // get client id
        if($client = $account->details->where('name','client')->first()){
            $data['client_id'] = json_decode($client->value, true)['client_id'];
        }
        // get db connection
        if($db_connection = $account->details->where('name','db_connection')->first()){
            $data['db_connection'] = $db_connection->value;
        }
        // get notice
        if( session('notice') !== NULL ){
            $data['notice'] = session('notice');
            $data['notice']['class'] = 'o-notice--space-around';
        }
        // return view
        return view('settings.developers', $data);
    }

    public function store(Request $request, $item){
        // generate api access
        if($item === 'api-access'){
            try{
                $client = (new ApiClientService)->create($this->account);
                // redirect on success
                return redirect('settings/developers')->with(['notice' => [
                    'data' => $client,
                    'template' => 'settings.credentials',
                    'type' => 'success',
                ]]);
            }catch(Exception $e){
                \Log::error($e);
            }
        }
    }

    public function delete(Request $request, $item){
        // get account
        $account = $request->user()->accounts->first();
        // delete client
        // TODO: deal with error when no data
        $client = json_decode($account->details->where('name','client')->first()->value);
        $detail = $account->details->where('name','client')->first();
        $detail->delete();
        $account->details()->detach($detail->id);
        $client = $this->api($this->config['cms'])->delete('/clients/'.$client->client_id);

        // delete cms client
        // TODO: deal with error when no data
        $cms_client = json_decode($account->details->where('name','cms_client')->first()->value);
        $detail = $account->details->where('name','cms_client')->first();
        $detail->delete();
        $account->details()->detach($detail->id);
        $cms_client = $this->api($this->config['cms'])->delete('/clients/'.$cms_client->client_id);
        // redirect to show
        return redirect('settings/developers')->with(['status' => 'Your API client has been deleted.', 'type' => 'warning']);
    }

    public function storeApiAccess($account){
        // get client
        $clients = $this->generateApiAccess($account->name);
        $accountDetailModel = new \App\Models\AccountDetail;
        // store client to account
        $account->details()->save($accountDetailModel->create([
            'name'  => 'client',
            'value' => json_encode([
                'client_id'     => $clients['client']['client_id'],
                'client_secret' => $clients['client']['client_secret'],
            ])
        ]));
        // store cms client to account
        $account->details()->save($accountDetailModel->create([
            'name'  => 'cms_client',
            'value' => json_encode([
                'client_id'     => $clients['cms']['client_id'],
                'client_secret' => $clients['cms']['client_secret'],
            ])
        ]));
        // redirect to show
        return redirect('settings/developers')->with(['notice' => [
            'data' => $clients['client'],
            'template' => 'settings.credentials',
            'type' => 'success',
        ]]);
    }

    public function generateApiAccess($name){
        // get new client
        $client = $this->api($this->config['cms'])->post('/clients', [
            'type' => 'clients',
            'attributes' => [
                'name' => $name,
                'scopes' => 'content.get',
            ]
        ])['data'];
        // get new cms client
        $cms = $this->api($this->config['cms'])->post('/clients', [
            'type' => 'clients',
            'attributes' => [
                'name' => '[cms] '.$name,
                'scopes' => 'content.get,content.post,content.patch,content.delete',
            ]
        ])['data'];
        // return client and cms client
        return [
            'client' => [
                'client_id'     => $client['id'],
                'client_secret' => $client['attributes']['secret'],
            ],
            'cms' => [
                'client_id'     => $cms['id'],
                'client_secret' => $cms['attributes']['secret'],
            ],
        ];
    }
}
