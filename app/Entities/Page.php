<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use App\Services\Api\PageService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Page extends AbstractApiResourceEntity
{

    /**
     * transform attributes
     *
     * @method attributes
     *
     * @param  Array      $attributes
     *
     * @return array
     */
    protected function attributes($attributes)
    {
        return [
            'id'            => $attributes['id'],
            'resource_type' => $attributes['type'],
            'label'         => $attributes['attributes']['menu_label'],
            'slug'          => $attributes['attributes']['slug'],
            'published'     => (bool)$attributes['attributes']['published'],
            'language'      => $attributes['attributes']['language'],
            'title'         => $attributes['attributes']['title'],
            'description'   => $attributes['attributes']['description'],
            'is_trashed'    => $attributes['attributes']['is_trashed'],
        ];
    }
    /**
     * cache current entity by its id
     *
     * @method cacheSelf
     *
     * @param  string       $suffix [description]
     *
     * @return void
     */
    protected function cacheSelf(){
        // cache entity by id
        if(!isset($this->cacheSelf) || (isset($this->cacheSelf) && $this->cacheSelf === true) ){
            Cache::put($this->get('id'),$this,1440);
            Cache::put(config('app.user')->account()->get('id').'.pages.'.$this->get('slug'),$this,1440);
        }
    }
    /**
     * return the service to get api data
     *
     * @method resourceService
     *
     * @return App\Services\Api\AbsrtactApiService
     */
    protected function resourceService(){
        return new PageService();
    }
    /**
     * get the collection the current page is in
     *
     * @method parentCollection
     *
     * @return App\Entities\Collection
     */
    public function parentCollection()
    {
        // get data
        $data = $this->getCacheOrRetrieve('parentCollection', 'Collection');
        // return collection
        return $this->collectionData($data)->first();
    }
    /**
     * get parent collection from page relationship
     *
     * @method retrieveAccount
     *
     * @return Illuminate\Support\Collection
     */
    protected function retrieveParentCollection()
    {
        if($this->relationships->get('ownedByCollections') !== NULL){
            return $this->relationships->get('ownedByCollections');
        }

        $related = (new PageService)->relationship($this->get('id'), 'ownedByCollections');

        if(!isset($related['data'])){
            return NULL;
        }

        return (new LaravelCollection($related['data']))->map(function($item){
            return new LaravelCollection($item);
        });
    }
}
