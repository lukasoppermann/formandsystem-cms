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
     * return collections for account
     *
     * @method collections
     *
     * @param  string      $field [description]
     * @param  string      $key   [description]
     * @param  bool      $first [description]
     *
     * @return Illuminate\Support\Collection
     */
    public function collections($field = NULL, $key = NULL, $first = false)
    {
        // get data
        $data = $this->getCacheOrRetrieve('Collections','Collection');
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
    public function retrieveCollections()
    {
        $collections = (new \App\Services\Api\CollectionService)->find('type','posts', [
            'only' => false
        ]);
        // cache included
        $this->cacheAsEntities($collections['included']);
        // return as collection
        return (new LaravelCollection($collections['data']))->map(function($item){
            return new LaravelCollection($item);
        });
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
        // cache included
        $this->cacheAsEntities($metadetails['included']);
        // return as collections
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
        // get collection with only pages
        $items = (new CollectionService)->find('type','navigation', [
            'only' => 'pages'
        ]);
        // cache included items
        $this->cacheAsEntities($items['included']);
        // return as collections
        return (new LaravelCollection($items['data']))->map(function($item){
            return new LaravelCollection($item);
        });
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
