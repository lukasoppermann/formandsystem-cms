<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;
use App\Services\Api\FragmentService;

class Fragment extends AbstractApiResourceEntity
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
    /**
     * return the service to get api data
     *
     * @method resourceService
     *
     * @return App\Services\Api\AbsrtactApiService
     */
    protected function resourceService(){
        return new FragmentService();
    }
}
