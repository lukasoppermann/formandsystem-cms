<?php

namespace App\Entities;

use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractEntity extends LaravelCollection
{
    /**
     * entities items
     *
     * @var array
     */
    protected $items;
    /**
     * retrieve data and build collection
     *
     * @method __construct
     *
     * @param  mixed     $data [description]
     */
    public function __construct($data)
    {
        // TODO: deal with errors e.g. when no model exists, etc.
        $this->refreshSelf($data);
    }
    /**
     * get classname for current class without namespace
     *
     * @method getClassName
     *
     * @return string
     */
    protected function getClassName($class = NULL) {
        // set class to $this if not set
        $class !== NULL ? : $class = $this;
        // get class name
        $class_name = explode('\\', get_class($class));
        // return class
        return array_pop($class_name);
    }
    /**
     * get a cache name for the current entity
     *
     * @method getCacheName
     *
     * @param  string       $suffix [description]
     *
     * @return string
     */
    protected function getCacheName($suffix = NULL)
    {
        if($this->getId() !== FALSE){
            return trim($this->getClassName().'.'.$this->getId().'.'.$suffix,'.');
        }
    }
    /**
     * get entities with array of entity ids & entity name
     *
     * @method getEntities
     *
     * @param  Array      $ids    [description]
     * @param  String      $entity [description]
     *
     * @return Illuminate\Support\Collection
     */
    public function getEntities(Array $ids = NULL, $entity = NULL)
    {
        return (new LaravelCollection($ids))
            ->map(function($item) use ($entity) {
                try{
                    return new $entity($item);
                }catch(\EmptyException $e){
                    return NULL;
                }catch(\Exception $e){
                    \Log::error($e);
                    return NULL;
                }
            })->reject(function($item){
                return empty($item);
            });
    }
    /**
     * cache original item by its ID
     *
     * @method cacheRawItems
     *
     * @param  Collection|Model        $items [description]
     *
     * @return void
     */
    protected function cacheRawItems($items)
    {
        // loop through
        foreach($items as $item){
            // cache item by it
            Cache::put((new LaravelCollection($item))->get('id'), $item, 1440);
        }
    }
    /**
     * get data from cache or from original source
     *
     * @method getCacheOrRetrieve
     *
     * @param  string             $entity_name [description]
     *
     * @return Illuminate\Support\Collection
     */
    protected function getCacheOrRetrieve($cache_suffix, $entity_name)
    {
        // build cache name
        $cache_name = $this->getCacheName($this->getClassName().$cache_suffix);
        // check cache
        if(!Cache::has($cache_name)){
            // get items from db or api
            $items = $this->{'retrieve'.$cache_suffix}();
            // detect included items
            if(isset($items['data']) && isset($items['included'])){
                // cache included items
                $this->cacheRawItems($items['included']);
                // set $items to entities
                $items = $items['data'];
            }
            // cache entities
            $this->cacheRawItems($items);
            // store in cache
            Cache::put($cache_name, $items->pluck('id'), 1440);
        }
        // get entities
        $ids = Cache::get($cache_name, new LaravelCollection())->toArray();
        // return items
        return $this->getEntities($ids, 'App\Entities\\'.$entity_name);
    }
    /**
     * get ID of current entity
     */
    abstract protected function getId();
    /**
     * get an array from the source of current entity
     */
    abstract protected function getSourceArray($source);
    /**
     * get the source of current entity
     */
    abstract protected function getSource($source);
    /**
     * method to update the entities real data via api or model
     */
    abstract protected function entityUpdate(Array $data);
    /**
     * method to delete the entities real data via api or model
     */
    abstract protected function entityDelete();
    /**
     * create a new entity in DB
     *
     * @method entityCreate
     *
     * @param  Array        $data [description]
     *
     * @return Illuminate\Support\Collection
     */
    abstract protected function entityCreate(Array $data);
    /**
     * update entity & entities cache
     *
     * @method update
     *
     * @param  Array  $data [description]
     *
     * @return [type]
     */
    public function update(Array $data){
        // make update and new entity
        // to force-refresh cache
        return $this->refreshSelf($this->entityUpdate($data));
    }
    /**
     * set the current entity to new values
     *
     * @method refreshSelf
     *
     * @param  mixed      $data [description]
     *
     * @return void
     */
    public function refreshSelf($data)
    {
        // TODO: deal with errors e.g. when no model exists, etc.
        // create source if array given
        if(is_array($data)){
            $data = $this->entityCreate($data);
        }
        // get source
        $items = $this->getDataArray($data);
        // prepare items
        $this->items = $this->attributes($items);
        // cache itself
        $this->cacheSelf();
    }
    /**
     * cache current entity by its id
     *
     * @method cacheSelf
     *
     * @param  string       $suffix [description]
     *
     * @return void
     */
    protected function cacheSelf(){
        // cache entity by id
        if($this->cacheSelf !== false){
            Cache::put($this->get('id'),$this,1440);
        }
    }
    /**
     * delete entity and remove entities cache
     *
     * @method delete
     *
     * @return boolean
     */
    public function delete(){
        // delete entity
        $this->entityDelete();
        // remove entity from cache
        Cache::forget($this->getId());
        // return
        return true;
    }
    /**
     * return a new entity
     *
     * @method newEntity
     *
     * @param  mixed      $source [description]
     *
     * @return App\Entities\{Entity}
     */
    protected function newEntity($source){
        // get name of current class
        $classname = get_class($this);
        // return new instance of itself
        // to break cache
        return new $classname($source);
    }
    /**
     * add a relationship to current entity in db or via api
     *
     * @method addRelationship
     *
     * @param  App\Entities\AbstractEntity  $entity [description]
     */
    abstract protected function addRelationship(AbstractEntity $entity);
    /**
     * remove a relationship to current entity in db or via api
     *
     * @method removeRelationship
     *
     * @param  App\Entities\AbstractEntity  $entity [description]
     */
    abstract protected function removeRelationship(AbstractEntity $entity);
    /**
     * attach an entity to current entity
     *
     * @method attach
     *
     * @param App\Entities\{Entity} $entity [description]
     *
     * @return void
     */
    public function attach(AbstractEntity $entity)
    {
        // add relationship to model
        $this->addRelationship($entity);
        // get cache name
        $cache_name = $this->getCacheName($this->getClassName($entity));
        // add entity to attached array
        $attached = Cache::get($cache_name, new LaravelCollection())->push($entity->get('id'));
        // cache array
        Cache::put($cache_name,$attached,1440);
    }
    /**
     * detach an entity from current entity
     *
     * @method detach
     *
     * @param App\Entities\{Entity} $entity [description]
     *
     * @return void
     */
    public function detach(AbstractEntity $entity)
    {
        // add relationship to model
        $this->removeRelationship($entity);
        // get cache name
        $cache_name = $this->getCacheName($this->getClassName($entity));
        // add entity to attached array
        $attached = Cache::get($cache_name)->reject(function ($value) {
            return $value === $attached->$entity->get('id');
        });
        // cache array
        Cache::put($cache_name,$attached,1440);
    }
    /**
     * return data as a collection
     *
     * @method collectionData
     *
     * @param  LaravelCollection $collection [description]
     * @param  string            $field      [description]
     * @param  string            $key        [description]
     * @param  boolean            $first      [description]
     *
     * @return Illuminate\Support\Collection
     */
    protected function collectionData(LaravelCollection $collection, $field = NULL, $key = NULL, $first = false)
    {
        // check if specific items should be selected
        if($field !== NULL && $key !== NULL){
            $collection = $collection->where($field, $key);
        }
        // if only first item is supposed to be returned
        if($first === true){
            return $collection->first();
        }
        // return
        return $collection;
    }
    /**
     * prepare attributes
     *
     * @method attributes
     *
     * @param  mixed     $data [description]
     *
     * @return array
     */
    abstract protected function attributes($data);
    /**
     * get data of current entity as array
     *
     * @method getDataArray
     *
     * @param  mixed     $data [description]
     *
     * @return Array
     */
    abstract protected function getDataArray($data);
}
