<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Formandsystem\Api\Api;
use App\Services\CacheService;
use Illuminate\Http\Request;
use App\Http\Requests;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $config;

    protected $account;
    protected $user;

    public function __construct(Request $request){
        // get current user
        $this->user = $request->user();
        // get account
        $this->account = $request->user()->accounts->first();
        // set cms api settings
        $this->config['cms'] = [
            'client_id' => env('FS_API_CLIENT_ID'),
            'client_secret' => env('FS_API_CLIENT_SECRET'),
            'scopes' => ['client.post','client.delete','client.get'],
        ];
    }

    protected function buildNavigation($active = false){
        // get navigation array to not change original
        $navigation = $this->navigation;
        // set active item active
        if($active !== false){
            foreach($navigation['lists'] as $key => $list){
                if( ($found = array_search($active, array_column($list['items'], 'link'))) !== false ){
                    $navigation['lists'][$key]['items'][$found]['is_active'] = true;
                }
            }
        }
        return $navigation;
    }
    /**
     * returns an api wrapper instance
     *
     * @method api
     *
     * @param  array $config used to change user
     *
     * @return Api
     */
    protected function api($config = []){
        // prepare api config
        $config = array_merge([
            'client_id'     => env('USER_API_CLIENT_ID'),
            'client_secret' => env('USER_API_CLIENT_SECRET'),
            'scopes'        => ['content.get','content.post','content.delete','content.patch']
        ], $config);
        // return new API instance
        return new Api($config, new CacheService);
    }
}
