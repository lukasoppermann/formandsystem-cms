<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use Illuminate\Support\Collection as LaravelCollection;

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
            'meta'              => $attributes['attributes']['meta'],
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
    /**
     * update current entity in db
     *
     * @method entityUpdate
     *
     * @param  array       $data [description]
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function entityUpdate(Array $data){
        // TODO: deal with errors
        // update model
        $updated = $this->resourceService()->update($this->getId(), $data);
        if(isset($updated['data'])){
            // return updated model
            return new LaravelCollection($updated['data']);
        }
        \Log::error($updated);
    }
}
