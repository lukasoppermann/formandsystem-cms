<?php

namespace App\Entities;

class Image extends AbstractResourceEntity
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
            'filename'      => $attributes['filename'],
            'slug'          => $attributes['slug'],
            'link'          =>
                trim(config('app.account')->details->where('type','url')->first()->data,'/').'/'
                .trim(config('app.account')->details->where('type','directory')->where('name','images')->first()->data,'/').'/'
                .$attributes['filename'],
        ];
    }
}
