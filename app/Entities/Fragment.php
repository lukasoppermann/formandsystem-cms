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

        if(isset($rel['relationships']) && count($rel['relationships']) > 0){
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
        return [
            'type'         => $attributes['type'],
            'name'         => $attributes['name'],
            'data'         => $this->json_decode($attributes['data']),
            'is_trashed'   => $attributes['is_trashed'],
            'details'      => $details,
        ];
    }
}
