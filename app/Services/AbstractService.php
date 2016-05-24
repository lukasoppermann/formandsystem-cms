<?php

namespace App\Services;
use Formandsystem\Api\Api;
use App\Services\CacheService;
use Auth;

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
        $this->account = Auth::user()->accounts->first();
        if($client = $this->account->details->where('type','cms_client')->first()){
            $this->client = json_decode($client->data, true);
        }
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
    protected function api($config = []){
        // prepare config
        $config = array_merge([
            'client_id'     => NULL,
            'client_secret' => NULL,
            'scopes'        => ['content.get','content.post','content.delete','content.patch']
        ], $config);

        // return new API instance
        return new Api($config, new CacheService);
    }
}
