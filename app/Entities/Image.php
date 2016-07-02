<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;

class Image extends AbstractApiResourceEntity
{
    /**
     * the service class for this entity
     */
    protected $resourceService = '\App\Services\Api\ImageService';
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
            'filename'      => $attributes['attributes']['filename'],
            'slug'          => $attributes['attributes']['slug'],
            'link'          => trim(config('site_url'),'/').'/'.trim(config('img_dir'),'/').'/'.$attributes['attributes']['filename'],
        ];
    }
}
