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
                trim($this->account->details->where('type','url')->first()->data,'/').'/'
                .trim($this->account->details->where('type','dir_image')->first()->data,'/').'/'
                .$attributes['filename'],
        ];
    }
}
