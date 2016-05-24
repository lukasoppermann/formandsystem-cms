<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Services\ApiMetadetailService;

class Site extends Settings
{

    public function show(){
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/site');

        return view('settings.site', $data);
    }
    /**
     * store site settings
     *
     * @method store
     *
     * @param  Request $request
     */
    public function store(Request $request){
        $request_input = $request->only(['site_name']);
        // validate input
        $validator = Validator::make($request_input, [
            'site_name'   => 'string',
        ]);
        // if validation fails
        if($validator->fails()){
            return redirect('settings/site')
                ->withErrors($validator)
                ->withInput();
        }
        // TODO: deal with errors
        // if validation succeeds
        try{
            $detail = (new ApiMetadetailService)->store($request_input);
            // redirect on success
            return redirect('settings/site')->with([
                'status' => 'Your database connection ('.$request->get('connection_name').') has been saved.',
                'type' => 'success'
            ]);
        }catch(Exception $e){
            \Log::error($e);
        }
        // return error
        \Log::error('Error trying to add database options by user '.$this->user->email.'. Error: '.$response['status_code'].': '.$response['message'].'. Client ID: '.$client_id.'; CMS ID: '.$cms_id);
        return redirect('settings/developers')->with(['status' => 'Saving your database connection failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
    }
}
