<?php

namespace App\Entities;

use App\Entities\AbstractEntity;

abstract class AbstractModelEntity extends AbstractEntity
{
    /**
     * get id for current entity from source
     *
     * @method getId
     *
     * @return string
     */
    protected function getId()
    {
        return $this->source->id;
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
        // validate user data
        $validatedData = $this->validateCreate($data);
        // get model name
        $model = isset($this->model) ? $this->model : $this->getClassName();
        // get model namepsave
        $model_name = 'App\Models\\'.$model;
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
        // validate user data
        $validatedData = $this->validateUpdate($data);
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
        $related_name = isset($entity->source()->model) ? $entity->source()->model : strtolower($this->getClassName($entity)).'s';
        // attach if model exists
        if(method_exists($this->source, $related_name)){
            $this->source->{$related_name}()->save($entity->source);
        }
    }
    /**
     * validate data before update
     */
    abstract protected function validateUpdate(Array $data);
    /**
     * validate data before create
     */
    abstract protected function validateCreate(Array $data);
    /**
     * get model instance for given $id
     */
    abstract protected function getModel($id);
}
