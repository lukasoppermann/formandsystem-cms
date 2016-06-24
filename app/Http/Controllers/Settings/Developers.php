<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class Developers extends Settings
{

    public function show(Request $request){
        $data = [];
        // get client id
        if($client = config('app.account')->details->where('type','client')->first()){
            $data['client_id'] = $client->data['client_id'];
        }
        // get db connection
        if($db_connection = config('app.account')->details->where('type','database')->first()){
            $data['database'] = $db_connection->data['data'];
        }
        // get ftp images
        if($ftp_image = config('app.account')->details->where('type','ftp_image')->first()){
            $data['ftp_image'] = $ftp_image->data['data'];
        }
        // get ftp backup
        if($ftp_backup = config('app.account')->details->where('type','ftp_backup')->first()){
            $data['ftp_backup'] = $ftp_backup->data['data'];
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
