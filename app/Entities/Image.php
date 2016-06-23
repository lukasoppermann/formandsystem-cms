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
        $site_url = $img_dir = "";
        if(config('app.account') !== NULL && !config('app.account')->details->isEmpty()){
            $site_url = config('app.account')->details->where('name','site_url');
            $img_dir = config('app.account')->details->where('type','directory')->where('name','images');
            if(!$site_url->isEmpty()){
                $site_url = $site_url->first()->data;
            }
            if(!$img_dir->isEmpty()){
                $img_dir = $img_dir->first()->data;
            }
        }

        return [
            'filename'      => $attributes['filename'],
            'slug'          => $attributes['slug'],
            'link'          => trim($site_url.'/').'/'.trim($img_dir,'/').'/'.$attributes['filename'],
        ];
    }
}
