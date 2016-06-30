<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use Illuminate\Support\Collection as LaravelCollection;

abstract class AbstractApiResourceEntity extends AbstractCollectionEntity
{
    public function __call($method, $args)
    {
        // automatically include relationships
        if(array_key_exists($method, $this->source['relationships']) ){
            $this->relatedEntities($this->source['relationships'][$method]['data']);
        }
    }
    public function relatedEntities($relatedData)
    {
        $data = (new LaravelCollection($relatedData))->map(function($item){
            // get entity class
            $entity = '\App\Entities\\'.ucfirst(substr($item['type'],0 ,-1));
            // return entity if valid
            if(class_exists($entity)){
                return new $entity($item['id']);
            }
            // return item if invalid entity
            return $item;
        });

        dd($data);
    }
    /**
     * add included items to Entity
     *
     * @method include
     *
     * @param  array  $relationships
     * @param  array  $included
     *
     * @return array
     */
    public function include($relationships = [], $included = [])
    {
        $include = [];

        foreach($relationships as $type => $rel ){
            // create collection
            $include[$type] = new LaravelCollection;
            // include entities if data exists
            if(isset($rel['data']) && count($rel['data']) > 0){
                // create entity name
                $entity = '\App\Entities\\'.str_replace('OwnedBy','',rtrim(ucfirst($type),'s'));
                // add all items to collection
                foreach(array_column($rel['data'],'id') as $id){
                    if(($key = array_search($id, array_column($included,'id'))) !== false){
                        $include[$type]->push(new $entity($included[$key], $included));
                    }
                }
            }
        }
        return [
            'relationships' => new LaravelCollection($include)
        ];
    }
    /**
     * decode json or return string
     *
     * @method json_decode
     *
     * @param  string      $data
     *
     * @return array|string
     */
    public function json_decode($data)
    {
        // decode if json
        if( !is_array($data) && json_decode($data) !== null ){
            return json_decode($data);
        }
        // return data
        return $data;
    }
    /**
     * empty function shell
     *
     * @method related
     *
     * @return Array
     */
    public function related()
    {
        return [];
    }
    /**
     * get items from collection
     *
     * @method __get
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        // get relationship if requested directly
        if(!$this->has($key)){
            // return relationship if it exists
            if(isset($this->items['relationships'][$key])){
                return $this->items['relationships'][$key];
            }
        }
        // return normal if exists
        return $this->get($key);
    }
}
