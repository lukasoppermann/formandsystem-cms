<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Services\ApiClientDetailService;

class Ftp extends Settings
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
        $type = $request->get('ftp_account_type') === 'ftp_backup' ? 'ftp_backup' : 'ftp_image';
         $validator = Validator::make($request->all(), [
            $type.'_type'           => 'required|in:sftp,ftp',
            $type.'_host'           => 'required|regex:/^([a-zA-Z0-9]+(\.[a-zA-Z0-9]+)+.*)$/',
            $type.'_path'           => 'required|Regex:/^[A-Za-z0-9\-\_\/]+$/',
            $type.'_username'       => 'required',
            $type.'_password'       => 'required',
            $type.'_ssl'            => 'boolean',
        ], [
            $type.'_host.regex' => 'Please provide a valid domain to access your ftp accont, without http(s)://',
            $type.'_path.regex' => 'A valid path may only contain the following characters: A-Z, a-z, 0-9, /, - and _',
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
            'type' => $type,
            'data' => json_encode([
                'type'      => $request->get($type.'_type'),
                'host'      => $request->get($type.'_host'),
                'path'      => $request->get($type.'_path'),
                'username'  => $request->get($type.'_username'),
                'password'  => $request->get($type.'_password'),
                'ssl'       => (boolean) $request->get($type.'_ssl'),
            ])
        ];
        // store detail
        try{
            $detail = (new ApiClientDetailService)->create($this->account, $data, [
                'type' => $type,
                'data' => $type,
            ]);
            // redirect on success
            return redirect('settings/developers')->with([
                'status' => 'Your '.str_replace('_',' ',$type).' connection has been saved.',
                'type' => 'success'
            ]);
        }catch(Exception $e){
            \Log::error($e);
        }
        // return error
        \Log::error('Error trying to add '.$type.' options by user '.$this->user->email.'. Error: '.$response['status_code'].': '.$response['message'].'. Client ID: '.$client_id.'; CMS ID: '.$cms_id);

        return redirect('settings/developers')->with(['status' => 'Saving your '.str_replace('_',' ',$type).' connection failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
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
            (new ApiClientDetailService)->delete($this->account, $request->get('ftp_image_account_type'));
            // redirect on success
            return redirect('settings/developers')->with([
                'status' => 'Your FTP connection ('.str_replace('_',' ',$request->get('ftp_image_account_type')).') client has been deleted.',
                'type' => 'warning'
            ]);
        }catch(Exception $e){
            \Log::error($e);
        }
    }
}
