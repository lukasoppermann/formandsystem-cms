<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use Illuminate\Support\Collection as LaravelCollection;

abstract class AbstractApiResourceEntity extends AbstractCollectionEntity
{
    protected $items;

    public function __construct($item = [], &$included = [])
    {
        // included relationships
        $rel = $this->include($item['relationships'], $included);
        // build entity
        $this->items = array_merge([
                'id'             => $item['id'],
                'resource_type'  => $item['type'],
            ],
            $this->attributes($item['attributes'], $rel),
            $rel
        );
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
        if(!method_exists($this, $method_name) && method_exists($this->items, $method_name)){
            return $this->items->{$method_name}($args);
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
    protected abstract function attributes(Array $attributes, $rel = NULL);
}
