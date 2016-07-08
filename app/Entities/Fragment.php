<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;

class Fragment extends AbstractApiResourceEntity
{
    /**
     * the service class for this entity
     */
    protected $resourceService = '\App\Services\Api\FragmentService';
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
            'id'                => $attributes['id'],
            'resource_type'     => $attributes['type'],
            'position'          => $attributes['attributes']['position'],
            'type'              => $attributes['attributes']['type'],
            'name'              => $attributes['attributes']['name'],
            'data'              => $this->jsonDecode($attributes['attributes']['data']),
            'created_at'        => $attributes['attributes']['created_at'],
            'is_trashed'        => $attributes['attributes']['is_trashed'],
        ];
    }
    /**
     * delete item from database
     *
     * @method entityDelete
     *
     * @return void
     */
    protected function entityDelete(){
        // TODO: deal with errors
        $this->fragments()->each(function($item){
            $item->delete();
        });
        // delete from api
        $deleted = $this->resourceService()->delete($this->getId());
    }
}
