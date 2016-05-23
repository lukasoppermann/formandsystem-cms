<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class Developers extends Settings
{

    public function show(Request $request){
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/developers');
        // account
        $account = $request->user()->accounts->first();
        // get client id
        if($client = $account->details->where('type','client')->first()){
            $data['client_id'] = json_decode($client->data, true)['client_id'];
        }
        // get db connection
        if($db_connection = $account->details->where('type','database')->first()){
            $data['database'] = json_decode($db_connection->data, true)['data'];
        }
        // get ftp images
        if($ftp_image = $account->details->where('type','ftp_image')->first()){
            $data['ftp_image'] = json_decode($ftp_image->data, true)['data'];
        }
        // get ftp backup
        if($ftp_backup = $account->details->where('type','ftp_backup')->first()){
            $data['ftp_backup'] = json_decode($ftp_backup->data, true)['data'];
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
