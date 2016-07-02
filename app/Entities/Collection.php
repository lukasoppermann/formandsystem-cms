<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;

class Collection extends AbstractApiResourceEntity
{
    /**
     * the service class for this entity
     */
    protected $resourceService = '\App\Services\Api\CollectionService';
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
}
