<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class Developers extends Settings
{

    public function show(Request $request){
        $data['request'] = $request;
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/developers');
        // get client id
        $data['client_id'] = $request->user()->accounts->first()->client_id;
        // get notice
        if( session('notice') !== NULL ){
            $data['notice'] = session('notice');
            $data['notice']['class'] = 'o-notice--space-around';
        }
        // return view
        return view('settings.developers', $data);
    }

    public function store(Request $request, $item){
        // get account
        $account = $request->user()->accounts->first();
        // generate api access
        if($item === 'api-access'){
            return $this->storeApiAccess($account);
        }
        // save database settings
        if($item === 'database'){
            return $this->storeDatabase($request, $account);
        }
    }

    public function delete(Request $request, $item){
        // get account
        $account = $request->user()->accounts->first();
        // delete client
        $client = $this->api($this->config['cms'])->delete('/clients/'.$account->client_id);
        // remove info from account
        $account->client_id = NULL;
        $account->client_secret = NULL;
        $account->save();
        // redirect to show
        return redirect('settings/developers')->with(['status' => 'Your API client has been deleted.', 'type' => 'warning']);
    }

    public function storeApiAccess($account){
        // get client
        $client = $this->generateApiAccess($account->name);
        // store client to account
        $account->client_id = $client['client_id'];
        $account->client_secret = $client['client_secret'];
        $account->save();
        // redirect to show
        return redirect('settings/developers')->with(['notice' => [
            'data' => $client,
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

        return [
            'client_id'     => $client['id'],
            'client_secret' => $client['attributes']['secret'],
        ];
    }

    public function storeDatabase(Request $request, $account){
        // validate input
         $validator = Validator::make($request->all(), [
            'connection_name'   => 'required|string',
            'db_type'           => 'required|in:mysql',
            'host'              => 'required|ip',
            'database'          => 'required|alpha_dash',
            'db_user'           => 'required',
            'db_password'       => 'required',
        ]);

        if($validator->fails()){
            return redirect('settings/developers')
                ->withErrors($validator)
                ->withInput();
        }

        
    }
}
