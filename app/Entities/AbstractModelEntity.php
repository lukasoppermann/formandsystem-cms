<?php

namespace App\Entities;

use App\Entities\AbstractEntity;
use Cache;

abstract class AbstractModelEntity extends AbstractEntity
{
    /**
     * get id for current entity from source
     *
     * @method getId
     *
     * @return string
     */
    protected function getId($source = NULL)
    {
        if($source === NULL && !isset($this->source)){
            return FALSE;
        }

        if($source === NULL){
            $source = $this->source;
        }

        return $source->id;
    }
    /**
     * return current entities source as array
     *
     * @method getSourceArray
     *
     * @param  Illuminate\Database\Eloquent\Model $source [description]
     *
     * @return Array
     */
    protected function getSourceArray($source)
    {
        return $source->toArray();
    }
    /**
     * return current entities source from cache, db or api, etc.
     *
     * @method getSource
     *
     * @param  [type]    $source [description]
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function getSource($source)
    {
        // if source is not a model
        if(!is_a($source, 'Illuminate\Database\Eloquent\Model')){
            return $this->getModel($source);
        }
        // return source
        return $source;
    }
    /**
     * create a new entity in DB
     *
     * @method entityCreate
     *
     * @param  Array        $data [description]
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function entityCreate(Array $data){
        // get model namespaced name
        $model_name = 'App\Models\\'.$this->getModelName($this);
        // check if model exists
        if(class_exists($model_name)){
           // return newly created model
           return (new $model_name())->create($validatedData);
       }
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
        $this->source->update($validatedData);
        // return updated model
        return $this->source;
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
        $this->source->delete();
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
        $related_name = $this->getModelName($entity);
        // attach if model exists
        if(method_exists($this->source, $related_name)){
            $this->source->{$related_name}()->save($entity->source);
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
        if(method_exists($this->source, $related_name)){
            $this->source->{$related_name}()->detach($entity->get('id'));
        }
    }
    /**
     * get model for this entity
     *
     * @method getModel
     *
     * @param  string   $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function getModel($id){
        if(!Cache::has($id)){
            // throw expection if model is not found
            if( !$model = (new $this->getModelName($this))->find($id) ){
                throw new \App\Exceptions\EmptyException('No '.get_class($this).' with ID: '.$id.' found.');
            }
            // store account in cache
            Cache::put($model->id,$model,1440);
        }
        // return model from cache
        return Cache::get($id);
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
        // if modelname is set in entity
        if(isset($entity->source()->model)){
            return $entity->source()->model;
        }
        // else try to make name
        return strtolower($this->getClassName($entity)).'s';
    }
}
