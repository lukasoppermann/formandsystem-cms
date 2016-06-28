<?php

namespace App\Http\Controllers;

use App\Services\Api\MetadetailService;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Formandsystem\Api\Api;
use App\Services\CacheService;
use Illuminate\Http\Request;
use App\Entities\User;
use App\Http\Requests;
use App\Services\NavigationService;
use Validator;
use Illuminate\Support\Collection as LaravelCollection;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $config;
    protected $account;
    protected $user;
    protected $client;

    public function __construct(Request $request){
        \Log::debug('Cache user & account');
        // get current user
        config(['app.user' => new User($request->user()->id)]);
        // get account
        config(['app.active_account' => config('app.user')->accounts()->first()->get('id')]);
        config(['app.account' => config('app.user')->account()]);
        \Log::debug('Get Metadetails e.g. image_dir & site_url & store with account');
        // api client
        if($client = config('app.user')->account()->details()->where('type','cms_client')->first()){
            config(['app.user_client' => $client->get('data')]);
        }
        // TODO: replace everywhere
        $this->client = config('app.user_client');
        // set user config
        $this->setUserConfig();
        // set cms api settings
        $this->config['cms'] = [
            'client_id' => env('FS_API_CLIENT_ID'),
            'client_secret' => env('FS_API_CLIENT_SECRET'),
            'scopes' => ['client.post','client.delete','client.get'],
        ];
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
        ], $config->toArray());
        // return new API instance
        $d = debugbar();
        return new Api($config, new CacheService, $d);
    }
    /**
     * get user & account config from DB & set as config
     *
     * @method setUserConfig
     */
    public function setUserConfig()
    {
        // URLS & DIRECTORIES
        $details = config('app.user')->account()->metadetails();

        \Config::set('site_url', $details->where('type','site_url')->first()->get('data'));
        \Config::set('img_dir', $details->where('type','dir_images')->first()->get('data'));
        // GRID
        \Config::set('custom.fragments', config('app.account')->details()->where('type','fragment')->keyBy('name'));
        // GRID
        \Config::set('user.grid-sm',2);
        \Config::set('user.grid-md',12);
        \Config::set('user.grid-lg',16);
    }
    /**
     * validate items and get only the validated items
     *
     * @method getValidated
     *
     * @param  Illuminate\Http\Request      $request
     * @param  Array                        $rules
     * @param  Array                        $presets
     *
     * @return \Illuminate\Support\Collection
     */
    public function getValidated(Request $request, Array $rules, Array $presets = [])
    {
        // get data from request
        $data = array_merge( $presets, array_filter($request->only(array_keys($rules))) );
        // validate data
        $validator = Validator::make($data, $rules);
        // validation fails
        if($validator->fails()){
            return new LaravelCollection([
                'isInvalid'   => true,
                'validator'   => $validator,
            ]);
        }
        // return data as collection
        return new LaravelCollection($data);
    }
}
