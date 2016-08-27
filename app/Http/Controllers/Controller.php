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
        \Debugbar::stopMeasure('routes');
        \Debugbar::startMeasure('user','Get Current User');
        // get current user
        config(['app.user' => new User($request->user())]);
        // redirect if account not set up
        \Debugbar::stopMeasure('user');
        \Debugbar::startMeasure('active-account-id','Get Active Account ID');
        // get account

        config(['app.active_account' => config('app.user')->accounts()->first()->get('id')]);
        \Debugbar::stopMeasure('active-account-id');
        \Debugbar::startMeasure('active-account','Get Active Account');
        config(['app.account' => config('app.user')->account()]);
        \Debugbar::stopMeasure('active-account');
        \Debugbar::startMeasure('get-api-client','Get API Client Data');
        // api client
        if($client = config('app.user')->account()->details('type','cms_client',true)){
            config(['app.user_client' => $client->get('data')]);
        }
        // TODO: replace everywhere
        \Debugbar::stopMeasure('get-api-client');
        // set user config
        $this->setUserConfig();
        \Debugbar::addMeasure('Controller Setup done', LARAVEL_START, microtime(true));
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
        $config = new LaravelCollection($config);
        // prepare config
        $config = array_merge([
            'url'           => env('FS_API_URL'),
            'version'       => 1,
            'client_id'     => env('FS_API_CLIENT_ID'),
            'client_secret' => env('FS_API_CLIENT_SECRET'),
            'cache'         => false,
            'scopes'        => ['content.get','content.post','content.delete','content.patch']
        ], $config->toArray() );

        $handler = [];

        $debugBar = debugbar();
        // Get data collector.
        $timeline = $debugBar->getCollector('time');
        // Wrap the timeline.
        $profiler = new GuzzleHttp\Profiling\Debugbar\Profiler($timeline);
        // Add the middleware to the stack
        $stack = GuzzleHttp\HandlerStack::create();
        $stack->unshift(new GuzzleHttp\Profiling\Middleware($profiler));
        $handler = ['handler' => $stack];
        // New up the client with this handler stack.
        $guzzle = new GuzzleHttp\Client(array_merge(
            $handler
        ));

        // return new API instance
        return new Api($config, new CacheService, $guzzle);
    }
    /**
     * get user & account config from DB & set as config
     *
     * @method setUserConfig
     */
    public function setUserConfig()
    {
        \Debugbar::startMeasure('get-account-metadetails','Get Account Site_url & IMG Dir');
        // URLS & DIRECTORIES
        \Config::set('site_url', config('app.user')->account()->metadetails('type','site_url', true)->get('data'));
        \Config::set('img_dir', config('app.user')->account()->metadetails('type','dir_images', true)->get('data'));
        \Debugbar::stopMeasure('get-account-metadetails');
        // GRID
        \Debugbar::startMeasure('custom-fragments','Get Custom Fragment Blueprints');
        \Config::set('custom.fragments', config('app.user')->account()->details()->where('type','fragment')->keyBy('name'));
        \Debugbar::stopMeasure('custom-fragments');
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
        $allowed = collect(array_keys($rules))->map(function($item){
            if( $pos = strpos($item,'.')){
                return substr($item,0,$pos);
            }
            return $item;
        });
        $request_data = collect($request->all())->only($allowed->toArray());

        $data = array_merge( $presets, $request_data->toArray() );
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
