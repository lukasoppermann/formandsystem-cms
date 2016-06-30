<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use App\Services\Api\MetadetailService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Metadetail extends AbstractApiResourceEntity
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
    //         if( !$item = (new MetadetailService)->first('id', $id) ){
    //             throw new \EmptyException('No '.get_class($this).' with ID: '.$id.' found.');
    //         }
    //         // store account in cache
    //         Cache::put($id,$item,1440);
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
            'type'              => $attributes['attributes']['type'],
            'data'              => $this->json_decode($attributes['attributes']['data']),
            'is_trashed'        => $attributes['attributes']['is_trashed'],
        ];
    }
    /**
     * return thje service to get api data
     *
     * @method resourceService
     *
     * @return App\Services\Api\AbsrtactApiService
     */
    protected function resourceService(){
        return new ResourceService();
    }
    /**
     * validate user data
     *
     * @method validateUpdate
     *
     * @param  array          $data [description]
     *
     * @return array
     */
    protected function validateUpdate(array $data)
    {
        return $data;
    }
    /**
     * validate user data
     *
     * @method validateCreate
     *
     * @param  array          $data [description]
     *
     * @return array
     */
    protected function validateCreate(array $data)
    {
        return $data;
    }

}
