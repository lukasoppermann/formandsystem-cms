<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Services\ApiClientDetailService;

class Database extends Settings
{
    /**
     * create a new API CLIENT Detail
     *
     * @method store
     *
     * @param  Request $request
     */
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
        // TODO: deal with errors
        // if validation succeeds
        $data = [
            'type' => 'database',
            'data' => json_encode($request->only([
                'connection_name',
                'db_type',
                'host',
                'database',
                'db_user',
                'db_password',
            ])),
        ];
        // generate api access
        try{
            $detail = (new ApiClientDetailService)->create($this->account, $data, [
                'type' => 'database',
                'data' => $request->get('connection_name'),
            ]);
            // redirect on success
            return redirect('settings/developers')->with([
                'status' => 'Your database connection ('.$request->get('connection_name').') has been saved.',
                'type' => 'success'
            ]);
        }catch(Exception $e){
            \Log::error($e);
        }
        // return error
        \Log::error('Error trying to add database options by user '.$this->user->email.'. Error: '.$response['status_code'].': '.$response['message'].'. Client ID: '.$client_id.'; CMS ID: '.$cms_id);
        return redirect('settings/developers')->with(['status' => 'Saving your database settings failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
    }
    /**
     * delete an specific API CLIENT Detail
     *
     * @method delete
     *
     * @param  Request $request
     */
    public function delete(Request $request){
        try{
            (new ApiClientDetailService)->delete($this->account, 'database');
            // redirect on success
            return redirect('settings/developers')->with([
                'status' => 'Your API client has been deleted.',
                'type' => 'warning'
            ]);
        }catch(Exception $e){
            \Log::error($e);
        }
    }
}
