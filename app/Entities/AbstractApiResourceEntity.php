<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractApiResourceEntity extends AbstractCollectionEntity
{
    protected $resourceService;

    public function __call($method, $args)
    {
        // automatically include relationships
        if(array_key_exists($method, $this->source['relationships']) ){
            return $this->relatedEntities($this->source['relationships'][$method]['data']);
        }
    }

    public function relatedEntities($relatedData)
    {
        return (new LaravelCollection($relatedData))->map(function($item){
            // get entity class
            $entity = '\App\Entities\\'.ucfirst(substr($item['type'],0 ,-1));
            // return entity if valid
            if(class_exists($entity)){
                return new $entity($item['id']);
            }
            // return item if invalid entity
            return $item;
        });
    }
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
            if( !$item = (new $this->resourceService())->first('id', $id) ){
                throw new \EmptyException('No '.get_class($this).' with ID: '.$id.' found.');
            }
            // store item in cache
            Cache::put($id,$item,1440);
        }
        // return from cache
        return new LaravelCollection(Cache::get($id));
    }

    abstract protected function resourceService();
}
