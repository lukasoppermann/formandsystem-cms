<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use App\Services\Api\PageService as ResourceService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Page extends AbstractApiResourceEntity
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
