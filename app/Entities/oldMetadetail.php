<?php

namespace App\Entities;

class oMetadetail extends AbstractResourceEntity
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
    protected function attributes(Array $attributes, $rel = NULL)
    {
        return [
            'type'         => $attributes['type'],
            'data'         => $this->json_decode($attributes['data']),
            'is_trashed'   => $attributes['is_trashed'],
        ];
    }
}
