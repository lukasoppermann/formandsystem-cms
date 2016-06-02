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
        // get settings data
        $settings = (new ApiMetadetailService)->find('type',[
            'site_name',
            'analytics_code',
            'analytics_anonymize_ip',
        ]);

        // flatten
        $data['form'] = [];

        foreach ($settings as $item) {
            $data['form'][$item->type] = $item;
        }

        return view('settings.site', $data);
    }
    /**
     * store site settings
     *
     * @method store
     *
     * @param  Request $request
     */
    public function update(Request $request){
        $items = [
            'site_name',
            'analytics_code',
            'analytics_anonymize_ip',
        ];
        $request_input      = $request->only($items);
        $request_input_ids  = $request->only(array_map(function($item){
            return $item.'_id';
        }, $items));
        // validate input
        $validator = Validator::make($request_input, [
            'site_name'         => 'string',
            'analytics_code'    => 'regex:/^UA-\d{7}-\d{2}$/',
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
            (new ApiMetadetailService)->updateMany($request_input, $request_input_ids);
            // redirect on success
            return redirect('settings/site')->with([
                'status' => 'Your settings have been updated.',
                'type' => 'success'
            ]);
        }catch(Exception $e){
            \Log::error($e);
        }
        // return error
        return redirect('settings/site')->with(['status' => 'Saving your settings failed. Please contact us at support@formandsystem.com', 'type' => 'error']);
    }
}
