<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use App\Services\Api\CollectionService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Collection extends AbstractApiResourceEntity
{
    /**
     * get model for this entity
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
            if( !$items = (new CollectionService)->get($id) ){
                throw new \EmptyException('No '.get_class($this).' with ID: '.$id.' found.');
            }
            // store account in cache
            Cache::put($id,$items,1440);
        }
        // return model from cache
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
        return [
            'id'                => $attributes['id'],
            'resource_type'     => $attributes['type'],
            'name'              => $attributes['attributes']['type'],
            'name'              => $attributes['attributes']['name'],
            'slug'              => $attributes['attributes']['slug'],
            'is_trashed'        => $attributes['attributes']['is_trashed'],
        ];
    }
    /**
     * return pages for collection
     *
     * @method pages
     *
     * @param  string      $field [description]
     * @param  string      $key   [description]
     * @param  bool      $first [description]
     *
     * @return Illuminate\Support\Collection
     */
    // public function pages($field = NULL, $key = NULL, $first = false)
    // {
    //     // get data
    //     $data = $this->getCacheOrRetrieve('CollectionPages','Collection');
    //     // return collection
    //     return $this->collectionData($data, $field, $key, $first);
    // }
    /**
     * get pages for collection
     *
     * @method retrieveCollectionPages
     *
     * @return Illuminate\Support\Collection
     */
    public function retrieveCollectionPages()
    {
        \Log::debug('emtpty retrieveCollectionPages in Collection Entity');
        return ;
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
