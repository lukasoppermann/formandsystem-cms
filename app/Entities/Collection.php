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
    protected function attributes(Array $attributes)
    {
        return $attributes;
    }
}
