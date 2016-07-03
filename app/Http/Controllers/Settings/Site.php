<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use App\Services\Api\MetadetailService;

class Site extends Settings
{
    public function show(){
        // get settings data
        $settings = config('app.user')->account()->metadetails();
        // flatten
        $data['form'] = [];

        foreach ($settings as $item) {
            $data['form'][$item->get('type')] = $item;
        }

        return view('settings.site', $data);
    }

    /**
     * update site settings
     *
     * @method update
     *
     * @param  Request $request
     */
    public function update(Request $request){
        // get validated data
        $data = $this->getValidated($request, [
            'site_name' => 'string',
            'site_url' => 'required|url',
            'dir_images' => 'required',
            'analytics_code' => 'regex:/^UA-\d{7}-\d{2}$/',
            'analytics_anonymize_ip' => '',
        ]);
        // if validation fails
        if($data->get('isInvalid')){
            return redirect('settings/site')
                ->withErrors($data->get('validator'))
                ->withInput();
        }
        // TODO: deal with errors
        // if validation succeeds
        try{
            // update meta items
            $metadetails = ['site_name','site_url','dir_images','analytics_code','analytics_anonymize_ip'];
            foreach($metadetails as $type){
                $item = config('app.user')->account()->metadetails('type',$type,true);
                if( !isset($data[$type]) ){
                    if( !$item->isEmpty() ){
                        $item->delete();
                    }
                }else {
                    if( !$item->isEmpty() ){
                        $updated[] = $item->update(['data' => $data[$type]]);
                    }else{
                        $updated[] = config('app.user')->account()->attach(new \App\Entities\Metadetail([
                            'type' => $type,
                            'data' => $data[$type],
                        ]));
                    }
                }
            }
            // redirect on success
            return redirect('settings/site')->with([
                'status' => 'Your settings have been updated.',
                'type' => 'success'
            ]);
        }catch(Exception $e){
            \Log::error($e);
            // exception email
            // TODO: send exception email to support@formandsystem.com
            // return error
            return redirect('settings/site')->with(['status' => 'Saving your settings failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
        }
    }
}
