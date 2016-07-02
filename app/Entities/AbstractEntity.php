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
        //TODO: Remove, just for making sure no entity is passed
        if(is_subclass_of($data, '\App\Entities\AbstractEntity')){
            dd($data);
        }

        // TODO: deal with errors e.g. when no model exists, etc.
        // create source if array given
        if(is_array($data)){
            // = model or collection
            $data = $this->entityCreate($data);
        }

        // if is string = id given
        if(is_string($data)){
            $this->setEntityToId($data);
        }
        // if model or collection is given
        else {
            // check if is model
            if(is_a($data, 'Illuminate\Database\Eloquent\Model')){
                // set entities model
                $this->model = $data;
                $this->items = $this->attributes($data);
            }
            elseif(is_a($data, 'Illuminate\Support\Collection')){
                $this->items = $this->attributes($data);
                // get relationships
                $this->relationships = (new LaravelCollection($data['relationships']))->map(function($related){
                    if(isset($related['data'])){
                        return (new LaravelCollection($related['data']))->pluck('id');
                    }
                    return NULL;
                });
            }
            // cache itself
            $this->cacheSelf();
        }
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
        if(!isset($this->cacheSelf) || (isset($this->cacheSelf) && $this->cacheSelf === true) ){
            Cache::put($this->get('id'),$this,1440);
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
        // set real entity name
        $entity_name = '\App\Entities\\'.$entity_name;
        // build cache name
        $cache_name = $this->getCacheName($this->getClassName().$cache_suffix);
        // check cache
        if(!Cache::has($cache_name)){
            $ids = $this->retrieveIds($entity_name, $cache_name, $cache_suffix);
            Cache::put($cache_name, $ids, 1440);
        }
        // get entities
        if( $ids = Cache::get($cache_name) ){
            // return items
            return $this->getEntities($ids->toArray(), $entity_name);
        }
    }
    /**
     * retrieve item ids
     *
     * @method retrieveIds
     *
     * @param  string           $entity_name  [description]
     * @param  string           $cache_name   [description]
     * @param  string           $cache_suffix [description]
     *
     * @return void
     */
    public function retrieveIds($entity_name, $cache_name, $cache_suffix)
    {
        // get items from db or api
        $items = $this->{'retrieve'.$cache_suffix}();
        // if anything is returned
        if($items !== NULL){
            foreach($items as $item){
                // create new entity so it is cached
                $entities[] = new $entity_name($item);
            }
            // return ids
            return (new LaravelCollection($entities))->pluck('id');
        }
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
        else {
            throw \Exception('Cannot get ID via getId() from entity '.get_class($this));
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
        $entities = (new LaravelCollection($ids))->map(function($id) use ($entity) {
            // try to create new entity
            try{
                return new $entity($id);
            // empty exception means the entity was deleted
            }catch(\EmptyException $e){
                return NULL;
            }catch(\Exception $e){
                \Log::error($e);
                return NULL;
            }
        });
        // return entities that are not empty
        return $entities->reject(function($item){
            return empty($item);
        });
    }
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
        // make update
        $updated = $this->entityUpdate($data);
        // refresh entity
        return $this->refreshSelf($updated);
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
    }
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
        // add relationship to model or api
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
        // remove entity to attached array
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
    protected function collectionData(LaravelCollection $collection = NULL, $field = NULL, $key = NULL, $first = false)
    {
        // check if specific items should be selected
        if($field !== NULL && $key !== NULL){
            $collection = $collection->where($field, $key);
        }
        // return first item or all
        return ($first === true) ? $collection->first() : $collection;
    }
    /**
     * get ID of current entity
     */
    abstract protected function getId();
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
     * get an entity form cache or source by its id
     *
     * @method getEntityFromId
     *
     * @param  string          $id [description]
     *
     * @return App\Entities\AbstractEntity
     */
    abstract protected function setEntityToId(string $id);
}
