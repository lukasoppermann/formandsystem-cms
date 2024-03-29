<?php

namespace App\Services;
use Formandsystem\Api\Api;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Auth;
use GuzzleHttp;
use Illuminate\Support\Collection as LaravelCollection;

abstract class AbstractService
{
    /**
     * config
     *
     * @var array
     */
    protected $config;
    /**
     * current users account
     *
     * @var User object
     */
    protected $account;
    /**
     * the users oAuth id & secret
     *
     * @var array
     */
    protected $client;

    public function __construct()
    {
        // set cms api settings
        $this->config['cms'] = [
            'client_id' => env('FS_API_CLIENT_ID'),
            'client_secret' => env('FS_API_CLIENT_SECRET'),
            'scopes' => ['client.post','client.delete','client.get'],
        ];
    }
    /**
     * return an api wrapper instance
     *
     * @method api
     *
     * @return object
     */
    protected function api($config = NULL){
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
        if (function_exists('debugbar')) {
            $debugBar = debugbar();
            // Get data collector.
            $timeline = $debugBar->getCollector('time');
            // Wrap the timeline.
            $profiler = new GuzzleHttp\Profiling\Debugbar\Profiler($timeline);
            // Add the middleware to the stack
            $stack = GuzzleHttp\HandlerStack::create();
            $stack->unshift(new GuzzleHttp\Profiling\Middleware($profiler));
            $handler = ['handler' => $stack];
        }
        $guzzle = new GuzzleHttp\Client($handler);

        // return new API instance
        return new Api($config, new CacheService, $guzzle);
    }
}
