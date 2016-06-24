<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\ApiClientService;

class ApiAccess extends Settings
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
            $client = (new ApiClientService)->create($this->account);
            // redirect on success
            return redirect('settings/developers')->with(['notice' => [
                'data' => $client,
                'template' => 'settings.credentials',
                'type' => 'success',
            ]]);
        }catch(\Exception $e){
            \Log::error($e);
        }

        return back()->with([
            'status' => 'Creating your api token failed. Please contact us at support@formandsystem.com',
            'type' => 'error'
        ]);
    }
    /**
     * delete an API CLIENT
     *
     * @method delete
     *
     * @param  Request $request
     */
    public function delete(Request $request){
        try{
            (new ApiClientService)->delete($this->account);
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
