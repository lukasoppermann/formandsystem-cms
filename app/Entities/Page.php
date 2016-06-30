<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use App\Services\Api\newPageService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Page extends AbstractApiResourceEntity
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
            if( !$item = (new newPageService)->first('id', $id) ){
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
