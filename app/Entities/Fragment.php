<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;
use App\Services\Api\FragmentService;

class Fragment extends AbstractApiResourceEntity
{
    
    /**
     * get data for this entity
     *
     * @method getData
     *
     * @param  string   $id
     *
     * @return Illuminate\Support\Collection
     */
    protected function getData($id){
        if(!Cache::has($id)){
            // throw expection if account is not found
            if( !$item = (new ImageService)->first('id', $id) ){
                throw new \EmptyException('No '.get_class($this).' with ID: '.$id.' found.');
            }
            // store item in cache
            Cache::put($id,$item,1440);
        }
        // return from cache
        return new LaravelCollection(Cache::get($id));
    }
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
        // return attributes
        return [
            'id'            => $attributes['id'],
            'resource_type' => $attributes['type'],
            'type'         => $attributes['attributes']['type'],
            'name'         => $attributes['attributes']['name'],
            'data'         => $this->json_decode($attributes['attributes']['data']),
            'created_at'   => $attributes['attributes']['created_at'],
            'is_trashed'   => $attributes['attributes']['is_trashed'],
        ];
    }
}
