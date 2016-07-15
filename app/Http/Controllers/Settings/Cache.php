<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\ApiClientService;
use App\Entities\AccountDetail;
use GuzzleHttp;

class Cache extends Settings
{
    /**
     * create a new API CLIENT
     *
     * @method store
     *
     * @param  Request $request
     */
    public function store(Request $request){
        // generate api access
        try{
            $detail = config('app.user')->account()->details('name','code',true);
            if(!$detail->isEmpty()){
                $detail->update([
                    'data' => bin2hex(random_bytes(20)),
                ]);
            }
            else{
                $detail = config('app.user')->account()->attach(new AccountDetail([
                    'type' => 'cache',
                    'name' => 'code',
                    'data' => bin2hex(random_bytes(20)),
                ]));
            }
            // redirect on success
            return redirect('settings/developers')->with([
                'status' => 'Your new cache code has been created.',
                'type' => 'success',
            ]);
        }catch(\Exception $e){
            \Log::error($e);
        }

        return back()->with([
            'status' => 'Creating your cache code failed. Please contact us at support@formandsystem.com',
            'type' => 'error'
        ]);
    }
    /**
     * delete users cache
     *
     * @method store
     *
     * @param  Request $request
     */
    public function bust(Request $request){
        $code = config('app.user')->account()->details('name','code',true)->get('data',false);

        if($code !== false){

            $client = new GuzzleHttp\Client([
                'base_uri'   => config('app.user')->account()->metadetails('type','site_url',true)->get('data'),
                'exceptions' => false
            ]);

            $client->post('/bust-cache', [
                'body' => json_encode([
                    'code' => $code,
                ])
            ]);
        }

        return back();
    }
}
