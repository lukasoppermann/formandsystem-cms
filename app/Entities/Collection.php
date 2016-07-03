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
        // get data
        $data = $this->getCacheOrRetrieve('Pages', 'Page');
        // return collection
        return $this->collectionData($data, $field, $key, $first);
    }
    /**
     * get pages for collection from API
     *
     * @method retrievePages
     *
     * @return Illuminate\Support\Collection
     */
    public function retrievePages()
    {
        $pages = $this->resourceService()->relationship($this->get('id'), 'pages');
        // cache included
        $this->cacheAsEntities($pages['included']);
        // return as collection
        return (new LaravelCollection($pages['data']))->map(function($item){
            return new LaravelCollection($item);
        });
    }

}
