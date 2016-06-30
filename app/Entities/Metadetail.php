<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use App\Services\Api\MetadetailService as ResourceService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Metadetail extends AbstractApiResourceEntity
{
    protected $cacheSource = true;
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
