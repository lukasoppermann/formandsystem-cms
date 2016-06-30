<?php

namespace App\Entities;

use App\Entities\AbstractCollectionEntity;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractApiResourceEntity extends AbstractCollectionEntity
{
    protected $resourceService;

    public function __call($method, $args)
    {
        // automatically include relationships
        if(array_key_exists($method, $this->source['relationships']) ){
            return $this->relatedEntities($this->source['relationships'][$method]['data']);
        }
    }
    /**
     * return realted entities
     *
     * @method relatedEntities
     *
     * @param  Array          $relatedData [description]
     *
     * @return Illuminate\Support\Collection
     */
    public function relatedEntities($relatedData)
    {
        return (new LaravelCollection($relatedData))->map(function($item){
            // get entity class
            $entity = '\App\Entities\\'.ucfirst(substr($item['type'],0 ,-1));
            // return entity if valid
            if(class_exists($entity)){
                return new $entity($item['id']);
            }
            // return item if invalid entity
            return $item;
        });
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
    //     // get model name
    //     $model = isset($this->model) ? $this->model : $this->getClassName();
    //     // get model namepsave
    //     $model_name = 'App\Models\\'.$model;
    //     // check if model exists
    //     if(class_exists($model_name)){
    //        // return newly created model
    //        return (new $model_name())->create($validatedData);
    //    }
    }
    /**
     * get data for this entity
     *
     * @method getData
     *
     * @param  string   $id
     *
     * @return Illuminate\Support\Collection
     */
    protected function getData($id){
        if(!Cache::has($id)){
            // throw expection if account is not found
            if( !$item = $this->resourceService()->first('id', $id) ){
                throw new \EmptyException('No '.get_class($this).' with ID: '.$id.' found.');
            }
            // store item in cache
            Cache::put($id,$item,1440);
        }
        // return from cache
        return new LaravelCollection(Cache::get($id));
    }
    /**
     * delete item from database
     *
     * @method entityDelete
     *
     * @return void
     */
    protected function entityDelete(){
        // delete from api
        $deleted = $this->resourceService()->delete($this->getId());
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
        $updated = $this->resourceService()->update($this->getId(), $data);
        // return updated model
        return new LaravelCollection($updated['data']);
    }
    /**
     * return thje service to get api data
     *
     * @method resourceService
     *
     * @return App\Services\Api\AbsrtactApiService
     */
    abstract protected function resourceService();

    // SHOULD BE MOVED TO SERVICES


    /**
     * validate user data
     *
     * @method validateUpdate
     *
     * @param  array          $data [description]
     *
     * @return array
     */
    protected function validateUpdate(array $data)
    {
        return $data;
    }
    /**
     * validate user data
     *
     * @method validateCreate
     *
     * @param  array          $data [description]
     *
     * @return array
     */
    protected function validateCreate(array $data)
    {
        return $data;
    }
}
