<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;

class Database extends Settings
{
    public function store(Request $request){

        // validate input
         $validator = Validator::make($request->all(), [
            'connection_name'   => 'required|string',
            'db_type'           => 'required|in:mysql',
            'host'              => 'required|ip',
            'database'          => 'required|alpha_dash',
            'db_user'           => 'required',
            'db_password'       => 'required',
        ]);
        // if validation fails
        if($validator->fails()){
            return redirect('settings/developers')
                ->withErrors($validator)
                ->withInput();
        }
        // if validation succeeds
        $cms_id = json_decode($this->account->details->where('name','cms_client')->first()->value, true)['client_id'];
        $client_id = json_decode($this->account->details->where('name','client')->first()->value, true)['client_id'];
        // post details
        $response = $this->api($this->config['cms'])->post('/details', [
            'type' => 'details',
            'attributes' => [
                'type' => 'database',
                'data' => json_encode($request->only([
                    'connection_name',
                    'db_type',
                    'host',
                    'database',
                    'db_user',
                    'db_password',
                ])),
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

        if( !isset($response['status_code']) ){
            // store database connection name
            $this->account->details()->save((new \App\Models\AccountDetail)->create([
                'name'  => 'db_connection',
                'value' => $request->get('connection_name'),
            ]));

            return redirect('settings/developers')->with(['status' => 'Your database connection details have been saved.', 'type' => 'success']);
        }
        // return error
        \Log::error('Error trying to add database options by user '.$this->user->email.'. Error: '.$response['status_code'].': '.$response['message'].'. Client ID: '.$client_id.'; CMS ID: '.$cms_id);
        return redirect('settings/developers')->with(['status' => 'Saving your database settings failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
    }
}
