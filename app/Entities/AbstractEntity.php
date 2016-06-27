<?php

namespace App\Entities;

use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractEntity extends LaravelCollection
{
    protected $items;
    /**
     * current entities model
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;
    /**
     * retrieve model and build collection
     *
     * @method __construct
     *
     * @param  mixed     $item [description]
     */
    public function __construct($model)
    {
        // TODO: deal with errors e.g. when no model exists, etc.
        // create model if array given
        if(is_array($model)){
            $model = $this->create($model);
        }
        // get user model
        if(!is_a($model, 'Illuminate\Database\Eloquent\Model')){
            // check if active user is requested user
            $model = $this->getModel($model);
        }
        // set model
        $this->model = $this->cacheModel($model);
        // set items
        $this->items = $this->model->toArray();
    }
    /**
     * return current entities model
     *
     * @method model
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function model()
    {
        return $this->model;
    }
    /**
     * get classname for current class without namespace
     *
     * @method getClassName
     *
     * @return string
     */
    protected function getClassName($class = NULL) {
        $class !== NULL ?: $class = $this;
        // get class namespace
        $namespaced_class = explode('\\', get_class($class));
        // return class
        return array_pop($namespaced_class);
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
        return trim($this->getClassName().'.'.$this->model->id.'.'.$suffix,'.');
    }
    /**
     * cache current model by id
     *
     * @method cacheModel
     *
     * @param  string       $suffix [description]
     *
     * @return string
     */
    protected function cacheModel($model){
        // cache model by id
        if(isset($this->cacheModel) && $this->cacheModel === true){
            Cache::put($model->id,$model,1440);
        }
        // return model
        return $model;
    }
    /**
     * get model instance fo given $id
     */
    abstract protected function getModel($id);
    /**
     * update the current entities model
     */
    // abstract protected function makeUpdate($data);
    protected function makeUpdate($data){
        // update model
        $this->model->update($data);
        // return updated model
        return $this->model;
    }
    protected function makeDelete(){
        // update model
        $this->model->delete();
    }

    protected function create($data){
        // get model name
        $model_name = 'App\Models\\'.$this->getClassName();
        // check if model exists
        if(class_exists($model_name)){
           // return newly created model
           return (new $model_name())->create($data);
       }
    }
    /**
     * update
     */
    public function update($data){
        // make update and return model
        return $this->newEntity($this->makeUpdate($data));
    }
    /**
     * delete
     */
    public function delete(){
        $this->makeDelete();
        // remove cache
        Cache::forget($this->items['id']);
        // make update and return model
        return true;
    }
    /**
     * return a new entity
     *
     * @method newEntity
     *
     * @param  Illuminate\Database\Eloquent\Model      $model [description]
     *
     * @return App\Entities\{Entity}
     */
    protected function newEntity($model){
        // get name of current class
        $classname = get_class($this);
        // return new instance of itself
        // to break cache
        return new $classname($model);
    }
    /**
     * attach an entity to current entity
     *
     * @method attach
     *
     * @param App\Entities\{Entity} $entity [description]
     *
     * @return $this
     */
    public function attach(AbstractEntity $entity)
    {
        // add relationship to model
        $this->addRelationship($entity);
        // get cache name
        $cache_name = $this->getCacheName($this->getClassName($entity));
        // add to cache array
        if(($attached = Cache::get($cache_name)) === NULL){
            $attached = new LaravelCollection();
        }
        $attached->push($entity->get('id'));
        // cache
        Cache::put($cache_name,$attached,1440);
        // return
        return $this;
    }
}
