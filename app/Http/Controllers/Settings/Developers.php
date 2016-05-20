<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

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
}
