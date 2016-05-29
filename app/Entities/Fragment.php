<?php

namespace App\Entities;

class Fragment extends AbstractResourceEntity
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
    protected function attributes(Array $attributes)
    {
        return [
            'type'         => $attributes['type'],
            'name'         => $attributes['name'],
            'data'         => $this->json_decode($attributes['data']),
            'is_trashed'   => $attributes['is_trashed'],
        ];
    }
}
