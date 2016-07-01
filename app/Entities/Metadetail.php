<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use App\Services\Api\MetadetailService as ResourceService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Metadetail extends AbstractApiResourceEntity
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
        if(!isset($attributes['attributes'])){
            dd($attributes);
        }
        return [
            'id'                => $attributes['id'],
            'resource_type'     => $attributes['type'],
            'type'              => $attributes['attributes']['type'],
            'data'              => $this->jsonDecode($attributes['attributes']['data']),
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
}
