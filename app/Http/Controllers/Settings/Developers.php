<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Cache;

class Developers extends Settings
{

    public function show(Request $request){
        $data = [];
        // get client id
        if($client = config('app.user')->account()->details('type','client',true)){
            $data['client_id'] = $client->get('data')['client_id'];
        }
        // get db connection
        if($db_connection = config('app.user')->account()->details('type','database',true)){
            $data['database'] = $db_connection->get('data')['data'];
        }
        // get ftp images
        if($ftp_image = config('app.user')->account()->details('type','ftp_image',true)){
            $data['ftp_image'] = $ftp_image->get('data')['data'];
        }
        // get ftp backup
        if($ftp_backup = config('app.user')->account()->details('type','ftp_backup',true)){
            $data['ftp_backup'] = $ftp_backup->get('data')['data'];
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
