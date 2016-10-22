<?php

namespace App\Entities;

use Formandsystem\Content\Entities\AbstractModelEntity;
use Formandsystem\Content\Entities\AccountDetail;
use Formandsystem\Content\Services\Api\MetadetailService;
use Formandsystem\Content\Services\Api\CollectionService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Project extends AbstractModelEntity
{
    /**
     * model namespace or model instance
     *
     * @var string|Model
     */
    protected $model = '\App\Models\Team';

    function __get($name) {
        return $this->getModel()[$name];
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
        $cache_name = 'Account'.config('app.user')->account()->get('id').'Navigation';
        // retrieve if not cached
        if(!Cache::has($cache_name)){
            // get collection with only pages
            $items = (new CollectionService)->find('type','navigation', [
                'only' => 'pages',
                'exclude' => 'pages,fragments',
            ]);
            // cache data
            $this->cacheAsEntities($items['data']);
            // cache included items
            $this->cacheAsEntities($items['included']);
            // return as collections
            $ids = (new LaravelCollection($items['data']))->pluck('id');
            // cache ids
            Cache::put($cache_name, $ids, 1440);
        }
        // get entities
        if( $ids = Cache::get($cache_name) ){
            $entities = $this->getEntities($ids->toArray(), 'Formandsystem\Content\Entities\Collection');
            // update cache if needed
            if(count($ids) !== count($entities)){
                Cache::put($cache_name, $entities->pluck('id'), 1440);
            }
        }
        // return collection
        return $this->collectionData($entities, $field, $key, $first);
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
        $data = $this->getCacheOrRetrieve('Collection','Collection');
        // return collection
        return $this->collectionData($data, $field, $key, $first);
    }

    public function onlyCollections($field = NULL, $key = NULL, $first = false)
    {
        // get data
        $data = $this->getCacheOrRetrieve('OnlyCollections','OnlyCollections');
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
    public function retrieveOnlyCollections()
    {
        $collections = collect((new \Formandsystem\Content\Services\Api\CollectionService)->find('type',['posts','collections','pages'], [
            'exclude' => 'pages,fragments'
        ]));

        // cache included
        $this->cacheAsEntities($collections->get('included',[]));
        // return as collection
        return (new LaravelCollection($collections->get('data', [])))->map(function($item){
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
    public function retrieveCollection()
    {
        $collections = collect((new \Formandsystem\Content\Services\Api\CollectionService)->find('type',['posts','collections','pages'], [
            'only' => false,
            'exclude' => 'pages.fragments, pages.pages'
        ]));
        dd($collections);
        // cache included
        $this->cacheAsEntities($collections->get('included',[]));
        // return as collection
        return (new LaravelCollection($collections->get('data', [])))->map(function($item){
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
    public function retrieveMetadetail()
    {
        $metadetails = collect((new MetadetailService)->find('type',['site_url','dir_images','analytics_code','analytics_anonymize_ip','site_name']));
        // cache included
        $this->cacheAsEntities($metadetails->get('included',[]));
        // return as collections
        return (new LaravelCollection($metadetails->get('data', [])))->map(function($item){
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
     * prepare attributes
     *
     * @method attributes
     *
     * @param  mixed     $model [description]
     *
     * @return array
     */
    protected function attributes($model)
    {
        return $model->toArray();
    }
    /**
     * validate that account is setup correctly
     *
     * @method isSetup
     *
     * @return bool
     */
    public function isSetup()
    {
        $keys = [
            'client',
            'database',
            'ftp_image',
        ];
        return $this->details()->filter(function($item) use ($keys){
            return in_array($item['type'], $keys);
        })->count() === count($keys);
    }
}
