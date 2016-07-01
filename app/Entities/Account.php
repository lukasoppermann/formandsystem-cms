<?php

namespace App\Entities;

use App\Entities\AbstractModelEntity;
use App\Entities\AccountDetail;
use App\Services\Api\MetadetailService;
use App\Services\Api\CollectionService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Account extends AbstractModelEntity
{
    /**
     * model namespace or model instance
     *
     * @var string|Model
     */
    protected $model = '\App\Models\Account';
    /**
     * get model for this entity
     *
     * @method getModel
     *
     * @param  string   $id
     *
     * @return Array
     */
    // protected function getDataArray($id){
    //     if(!Cache::has($id)){
    //         // throw expection if account is not found
    //         if( config('app.user') === NULL
    //             || config('app.user')->accounts() === NULL
    //             || !$account = config('app.user')->model->accounts->where('id',$id)->first()
    //         ){
    //             throw new \App\Exceptions\EmptyException('No account with ID: '.$id.' found.');
    //         }
    //         // store account in cache
    //         // Cache::put($id,$account,1440);
    //         $this->model = $account;
    //         return $account->toArray();
    //     }
    //     // return model from cache
    //     return Cache::get($id);
    // }
    /**
     * return details that are related to account
     *
     * @method details
     *
     * @param  string      $field [description]
     * @param  string      $key   [description]
     * @param  bool      $first [description]
     *
     * @return Illuminate\Support\Collection
     */
    public function details($field = NULL, $key = NULL, $first = false)
    {
        // get data
        $data = $this->getCacheOrRetrieve('AccountDetail', 'AccountDetail');
        // return collection
        return $this->collectionData($data, $field, $key, $first);
    }
    /**
     * return metadetails that are related to account
     *
     * @method metadetails
     *
     * @param  string      $field [description]
     * @param  string      $key   [description]
     * @param  bool      $first [description]
     *
     * @return Illuminate\Support\Collection
     */
    public function metadetails($field = NULL, $key = NULL, $first = false)
    {
        // get data
        $data = $this->getCacheOrRetrieve('AccountMetadetail', 'Metadetail');
        // return collection
        return $this->collectionData($data, $field, $key, $first);
    }
    /**
     * return navigation for account
     *
     * @method navigation
     *
     * @param  string      $field [description]
     * @param  string      $key   [description]
     * @param  bool      $first [description]
     *
     * @return Illuminate\Support\Collection
     */
    public function navigation($field = NULL, $key = NULL, $first = false)
    {
        // get data
        $data = $this->getCacheOrRetrieve('Navigation','Collection');
        // return collection
        return $this->collectionData($data, $field, $key, $first);
    }
    /**
     * get metadetails for account from API
     *
     * @method retrieveAccountMetadetail
     *
     * @return Illuminate\Support\Collection
     */
    public function retrieveAccountMetadetail()
    {
        $metadetails = (new MetadetailService)->find('type',['site_url','dir_images','analytics_code','analytics_anonymize_ip','site_name']);
        // return data & included
        \Log::debug('Cache included data');
        //     'included'  => new LaravelCollection($metadetails['included']),
        return (new LaravelCollection($metadetails['data']))->map(function($item){
            return new LaravelCollection($item);
        });
    }
    /**
     * get account details from accounts relationship
     *
     * @method retrieveAccountdetail
     *
     * @return Illuminate\Support\Collection
     */
    public function retrieveAccountDetail()
    {
        return $this->getModel()->accountdetails;
    }
    /**
     * get navigation collection for account from API
     *
     * @method retrieveNavigation
     *
     * @return Illuminate\Support\Collection
     */
    public function retrieveNavigation()
    {
        $items = (new CollectionService)->find('type','navigation', [
            'only' => 'pages'
        ]);
        // return data & included
        return [
            'data'      => new LaravelCollection($items['data']),
            'included'  => new LaravelCollection($items['included']),
        ];
    }
    /**
     * prepare attributes
     *
     * @method attributes
     *
     * @param  mixed     $source [description]
     *
     * @return array
     */
    protected function attributes($model)
    {
        return $model->toArray();
    }
}
