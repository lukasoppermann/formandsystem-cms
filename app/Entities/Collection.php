<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use App\Services\Api\CollectionService as ResourceService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Collection extends AbstractApiResourceEntity
{
    protected $cacheSource = true;
    /**
     * get model for this entity
     *
     * @method getData
     *
     * @param  string   $id
     *
     * @return Illuminate\Support\Collection
     */
    // protected function getData($id){
    //     if(!Cache::has($id)){
    //         // throw expection if account is not found
    //         if( !$items = (new CollectionService)->get($id) ){
    //             throw new \EmptyException('No '.get_class($this).' with ID: '.$id.' found.');
    //         }
    //         // store account in cache
    //         Cache::put($id,$items,1440);
    //     }
    //     // return model from cache
    //     return new LaravelCollection(Cache::get($id));
    // }
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
            'id'                => $attributes['id'],
            'resource_type'     => $attributes['type'],
            'name'              => $attributes['attributes']['type'],
            'name'              => $attributes['attributes']['name'],
            'slug'              => $attributes['attributes']['slug'],
            'is_trashed'        => $attributes['attributes']['is_trashed'],
        ];
    }
    protected function resourceService(){
        return new ResourceService();
    }
}
