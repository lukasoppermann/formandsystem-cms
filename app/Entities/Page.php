<?php

namespace App\Entities;

class Page extends AbstractResourceEntity
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
            'label'         => $attributes['menu_label'],
            'slug'          => $attributes['slug'],
            'published'     => (bool)$attributes['published'],
            'language'      => $attributes['language'],
            'title'         => $attributes['title'],
            'description'   => $attributes['description'],
            'is_trashed'    => $attributes['is_trashed'],
        ];
    }
}
