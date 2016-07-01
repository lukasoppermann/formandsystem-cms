<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use App\Services\Api\PageService as ResourceService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Page extends AbstractApiResourceEntity
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
     * return the service to get api data
     *
     * @method resourceService
     *
     * @return App\Services\Api\AbsrtactApiService
     */
    protected function resourceService(){
        return new ResourceService();
    }
}
