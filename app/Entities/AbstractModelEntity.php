<?php

namespace App\Entities;

use App\Entities\AbstractEntity;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractModelEntity extends AbstractEntity
{
    /**
     * $model of data for entity
     *
     * @var mixed
     */
    protected $model = NULL;
    /**
     * get an entity form cache or $model by its id
     *
     * @method getEntityFromId
     *
     * @param  string          $id [description]
     *
     * @return App\Entities\AbstractEntity
     */
    public function getEntityFromId($id)
    {
        // try to get from cache
        if(\Cache::has($id)){
            return \Cache::get($id);
        }
        // get from model
        return new $this($this->getModel()->find($id));
    }
    public function setEntityToId($id)
    {
        // try to get from cache
        if(\Cache::has($id)){
            $entity = \Cache::get($id);
        }else {
            $model = $this->getModel()->find($id);

            if($model !== NULL){
                $entity = new $this($model);
            }else {
                throw new \App\Exceptions\EmptyException();
            }
        }
        $this->model = $entity->getModel();
        $this->items = $entity->items;
    }
    /**
     * get id for current entity from $model
     *
     * @method getId
     *
     * @return string
     */
     protected function getId()
     {
         try{
             return $this->get('id');
         }catch(\Exception $e){
             \Log::error($e);
             return FALSE;
         }
     }
     /**
      * get the model for the current entity
      *
      * @method getModel
      *
      * @return [type]
      */
     public function getModel($id = NULL)
     {
        if(is_a($this->model, 'Illuminate\Database\Eloquent\Model')){
            return $this->model;
        }
        if($id === NULL && isset($this->items['id'])){
            $id = $this->items['id'];
        }
        if($id !== null){
            return (new $this->model)->find($id);
        }
        return (new $this->model);
     }
    /**
     * create a new entity in DB
     *
     * @method entityCreate
     *
     * @param  Array        $data [description]
     *
     * @return Illuminate\Support\Collection
     */
    protected function entityCreate(Array $data){
       // create model
       $model = $this->getModel()->create($data);
       // return collection
       return $model;
    }
    /**
     * update current entity in db
     *
     * @method entityUpdate
     *
     * @param  array       $data [description]
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function entityUpdate(Array $data){
        // update model
        $model = $this->getModel()->update($data);
        // return updated model
        return $this->getModel();
    }
    /**
     * delete item from database
     *
     * @method entityDelete
     *
     * @return void
     */
    protected function entityDelete(){
        // update model
        $this->getModel()->delete();
    }
    /**
     * add a relationship to the entities model
     *
     * @method addRelationship
     *
     * @param  App\Entities\AbstractEntity  $entity [description]
     */
    protected function addRelationship(AbstractEntity $entity)
    {
        // create the models name
        $related_name = strtolower($this->getModelName($entity));
        // attach if model exists
        if( method_exists($this->getModel(), $related_name) ){
            $this->getModel()->{$related_name}()->save($entity->getModel());
        }
    }
    /**
     * remove a relationship from the entities model
     *
     * @method removeRelationship
     *
     * @param  App\Entities\AbstractEntity  $entity [description]
     */
    protected function removeRelationship(AbstractEntity $entity)
    {
        // create the models name
        $related_name = $this->getModelName($entity);
        // attach if model exists
        if(method_exists($this->getModel(), $related_name)){
            $this->getModel()->{$related_name}()->detach($entity->get('id'));
        }
    }
    /**
     * get model name for given entity
     *
     * @method getModelName
     *
     * @param  App\Entities\AbstractEntity $entity [description]
     *
     * @return string
     */
    protected function getModelName($entity)
    {
        // else try to make name
        return strtolower($this->getClassName($entity)).'s';
    }
}
