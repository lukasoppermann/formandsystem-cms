<?php

namespace App\Entities;

use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractEntity extends LaravelCollection
{
    /**
     * source of data for entity
     *
     * @var mixed
     */
    protected $source;
    /**
     * entities items
     *
     * @var array
     */
    protected $items;
    /**
     * retrieve model and build collection
     *
     * @method __construct
     *
     * @param  mixed     $data [description]
     */
    public function __construct($data)
    {
        // TODO: deal with errors e.g. when no model exists, etc.
        // create source if array given
        if(is_array($data)){
            $source = $this->entityCreate($data);
        }
        // get source
        if(!isset($source)){
            $source = $this->getSource($data);
        }
        // set items
        $this->setItems($this->getSourceArray($source));
        // set model
        $this->source = $this->cacheSource($source);
    }
    /**
     * set items to provided array
     *
     * @method setItems
     *
     * @param  Array    $items [description]
     */
    public function setItems(Array $items)
    {
        $this->items = $items;
    }
    /**
     * get the source model or data object
     *
     * @method source
     *
     * @return mixed
     */
    public function source()
    {
        return $this->source;
    }
    /**
     * check if entity is a model entity
     *
     * @method isModelEntity
     *
     * @return bool
     */
    public function isModelEntity()
    {
        return is_a($this->source, 'Illuminate\Database\Eloquent\Model');
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
        return trim($this->getClassName().'.'.$this->getId().'.'.$suffix,'.');
    }
    /**
     * cache current source by its id
     *
     * @method cacheSource
     *
     * @param  string       $suffix [description]
     *
     * @return string
     */
    protected function cacheSource($source){
        // cache source by id
        if(isset($this->cacheSource) && $this->cacheSource === true){
            Cache::put($this->items['id'],$source,1440);
        }
        // return model
        return $source;
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
     * method to create the entities real data via api or model
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
        return $this->newEntity($this->entityUpdate($data));
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
}
