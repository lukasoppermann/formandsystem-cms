<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use Illuminate\Support\Collection as LaravelCollection;

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
            'position'          => $attributes['attributes']['position'],
            'type'              => $attributes['attributes']['type'],
            'name'              => $attributes['attributes']['name'],
            'slug'              => $attributes['attributes']['slug'],
            'is_trashed'        => $attributes['attributes']['is_trashed'],
        ];
    }
    /**
     * get the pages
     *
     * @method pages
     *
     * @return App\Entities\Collection
     */
    public function pages($field = NULL, $key = NULL, $first = false)
    {
        $entities = $this->relatedEntities('pages', $field, $key, $first);
        // sort by position
        if($first === false){
            $entities = $entities->sortBy('position');
        }
        // return collection
        return $entities;
    }

}
