<?php

namespace App\Entities;

use Illuminate\Support\Collection as LaravelCollection;

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
    protected function attributes(Array $attributes, $rel = NULL)
    {
        $details = new LaravelCollection;
        //
        // if(isset($rel['relationships']) && count($rel['relationships']) > 0){
        //     if(isset($rel['relationships']['metadetails']) && count($rel['relationships']['metadetails']) > 0)
        //     $rel['relationships']->get('metadetails')->each(function($item) use ($details){
        //         if($details->has($item->type)){
        //             $value = $details->get($item->type);
        //             $value = is_array($value) ? $value : [$value];
        //             $details->put($item->type, array_merge([$item->data],$value));
        //         }else{
        //             $details->put($item->type, $item->data);
        //         }
        //     });
        // }
        $related = [
            'details' => new LaravelCollection,
            'images' => new LaravelCollection,
        ];

        if(isset($rel['relationships']) && count($rel['relationships']) > 0){

            if(isset($rel['relationships']['metadetails']) && count($rel['relationships']['metadetails']) > 0)
            $rel['relationships']->get('metadetails')->each(function($item) use ($details){
                if($details->has($item->type)){
                    $value = $details->get($item->type);
                    $value = is_array($value) ? $value : [$value];
                    $details->put($item->type, array_merge([$item->data],$value));
                }else{
                    $details->put($item->type, $item->data);
                }
            });
        }
        // return attributes
        return array_merge([
            'type'         => $attributes['type'],
            'name'         => $attributes['name'],
            'data'         => $this->json_decode($attributes['data']),
            'is_trashed'   => $attributes['is_trashed'],
            'details'      => $details,
        ], $this->related());
    }
}
