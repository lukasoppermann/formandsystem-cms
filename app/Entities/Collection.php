<?php

namespace App\Entities;

class Collection extends AbstractResourceEntity
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
            'name'         => $attributes['name'],
            'slug'         => $attributes['slug'],
            'is_trashed'   => $attributes['is_trashed'],
        ];
    }
}
