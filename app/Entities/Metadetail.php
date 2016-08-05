<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
// use  \App\Services\Api\MetadetailService as ResourceService;

class Metadetail extends AbstractApiResourceEntity
{
    /**
     * the service class for this entity
     */
    protected $resourceService = '\App\Services\Api\MetadetailService';
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
            'data'              => $this->jsonDecode($attributes['attributes']['data']),
            'is_trashed'        => $attributes['attributes']['is_trashed'],
        ];
    }
}
