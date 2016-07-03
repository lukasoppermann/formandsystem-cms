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

        $data = $this->getValidated($request, [
            'site_name_id' => '',
            'site_name' => 'string',
            'site_url' => 'required|url',
            'site_url_id' => '',
            'dir_images' => 'required',
            'dir_images_id' => '',
            'analytics_code_id' => '',
            'analytics_code' => 'regex:/^UA-\d{7}-\d{2}$/',
            'analytics_anonymize_ip_id' => '',
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
            $metadetails = ['site_name','analytics_code','analytics_anonymize_ip','site_url','dir_images'];
            foreach($metadetails as $meta){
                if(isset($data[$meta])){
                    if (isset($data[$meta.'_id'])){
                        (new MetadetailService)->update($data[$meta.'_id'], [
                            'data' => $data[$meta],
                        ]);
                    }
                    else {
                        (new MetadetailService)->create([
                            'type' => $meta,
                            'data' => $data[$meta],
                        ]);
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
