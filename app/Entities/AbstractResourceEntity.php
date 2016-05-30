<?php

namespace App\Entities;

use Illuminate\Support\Collection as LaravelCollection;

abstract class AbstractResourceEntity
{
    protected $entity;

    public function __construct($item = [], &$included = [])
    {
        // build entity
        $this->entity = new LaravelCollection(array_merge([
                'id'             => $item['id'],
                'resource_type'  => $item['type'],
            ],
            $this->attributes($item['attributes']),
            // add included
            $this->include($item['relationships'], $included)
        ));
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
            // include entities if data exists
            if(isset($rel['data']) && count($rel['data']) > 0){
                // create entity name
                $entity = '\App\Entities\\'.rtrim(ucfirst($type),'s');
                // // create collection
                $include[$type] = new LaravelCollection;
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
        if(!$this->entity->has($key)){
            // return relationship if it exists
            if(isset($this->entity['relationships'][$key])){
                return $this->entity['relationships'][$key];
            }
        }
        // return normal if exists
        return $this->entity->get($key);
    }
    /**
     * call methods on collection if they do not exist on Entity
     *
     * @method __call
     *
     * @param  string $method_name
     * @param  mixed $args
     *
     * @return mixed
     */
    public function __call($method_name, $args)
    {
        if(!method_exists($this, $method_name) && method_exists($this->entity, $method_name)){
            return $this->entity->{$method_name}($args);
        }
    }
    /**
     * transform attributes
     *
     * @method attributes
     *
     * @param  Array      $attributes
     *
     * @return array
     */
    protected abstract function attributes(Array $attributes);
}
