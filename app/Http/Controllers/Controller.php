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
    protected $navigation;

    public function __construct(Request $request){
        \Log::debug('Cache user & account');
        // get current user
        $this->user = $request->user();
        config(['app.user' => $this->user]);
        // get account
        $this->account = $request->user()->accounts->first();
        config(['app.account' => $this->account]);
        \Log::debug('Get Metadetails e.g. image_dir & site_url & store with account');
        // api client
        if($client = $this->account->details->where('type','cms_client')->first()){
            $this->client = (array) $client->data;
        }
        // set user config
        $this->setUserConfig();
        // set cms api settings
        $this->config['cms'] = [
            'client_id' => env('FS_API_CLIENT_ID'),
            'client_secret' => env('FS_API_CLIENT_SECRET'),
            'scopes' => ['client.post','client.delete','client.get'],
        ];
        // Build navigation
        $this->navigation();
        // $navigation->get();
    }

    protected function navigation()
    {
        if( app('request')->method() === 'GET' ){
            // get menu if needed
            if( method_exists($this, 'getMenu') ){
                $this->getMenu();
            }
            // active menu item urls
            view()->share('active_item', '/'.trim(app('request')->path(),'/'));
            // navigation
            view()->share('navigation', $this->buildNavigation());
        }
    }

    protected function buildNavigation($active = false){

        // get navigation array to not change original
        $navigation = $this->navigation;
        // set active item active
        if($active !== false && isset($navigation['lists'])){
            foreach($navigation['lists'] as $key => $list){
                // build array
                if( isset($list['items']) && count($list['items']) > 0 && ($found = array_search($active, array_column($list['items'], 'link'))) !== false ){
                    $navigation['lists'][$key]['items'][$found]['is_active']= true;
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
    /**
     * get user & account config from DB & set as config
     *
     * @method setUserConfig
     */
    public function setUserConfig()
    {
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
