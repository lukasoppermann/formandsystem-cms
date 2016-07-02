<?php

namespace App\Entities;

use App\Entities\AbstractEntity;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractApiResourceEntity extends AbstractEntity
{

    protected $resourceService;
    protected $relationships = NULL;

    public function __call($method, $args)
    {
        // automatically include relationships
        if($this->relationships !== NULL && $this->relationships->has($method)){
            return $this->relatedEntities($method);
        }
    }
    /**
     * get an entity form cache or source by its id
     *
     * @method getEntityFromId
     *
     * @param  string          $id [description]
     *
     * @return App\Entities\AbstractEntity
     */
    // public function getEntityFromId(string $id)
    // {
    //     // try to get from cache
    //     if(\Cache::has($id)){
    //         return \Cache::get($id);
    //     }
    //
    //     // get from model
    //     return new $this(new LaravelCollection($this->resourceService()->first('id',$id)));
    // }
    public function setEntityToId(string $id)
    {
        // try to get from cache
        if(\Cache::has($id)){
            $entity = \Cache::get($id);
        }else {
            $entity = new $this(new LaravelCollection($this->resourceService()->first('id',$id)));
        }
        //
        $this->items = $entity->items;
        //#
        $this->relationships = $entity->relationships;
    }
    /**
     * get id for current entity from source
     *
     * @method getId
     *
     * @return string
     */
    protected function getId($source = NULL)
    {
        try{
            return $this->get('id');
        }catch(\Exception $e){
            \Log::error($e);
            return FALSE;
        }
    }
    /**
     * return current entities source as array
     *
     * @method getSourceArray
     *
     * @param Illuminate\Support\Collection $source [description]
     *
     * @return Array
     */
    protected function getSourceArray($source)
    {
        return $source->toArray();
    }
    /**
     * return json as array or string, if not valid json
     *
     * @method jsonDecode
     *
     * @param  [type]    $source [description]
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function jsonDecode($str)
    {
        // try to convert json
        $json = json_decode($str,true);
        if(is_array($json)){
            return $json;
        }
        // if not return string
        return $str;
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
    public function relatedEntities($relatedType)
    {
        $data = (new LaravelCollection($this->relationships[$relatedType]))->map(function($id) use ($relatedType){
            // get entity class
            $entity = '\App\Entities\\'.ucfirst(substr($relatedType,0 ,-1));
            // return entity if valid
            try{
                if(class_exists($entity)){
                    return new $entity($id);
                }
            }catch(\App\Exceptions\EmptyException $e){
                return NULL;
            }
        })->reject(function($item){
            return empty($item);
        });
        $newRelationships = $data->pluck('id')->map(function($item) use ($relatedType){
            return [
                'type' => $relatedType,
                'id'   => $item,
            ];
        });

        $this->relationships->put($relatedType, $newRelationships);
        // return data
        return $data;
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
                throw new \App\Exceptions\EmptyException('No '.get_class($this).' with ID: '.$id.' found.');
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
        // TODO: deal with errors
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
        // TODO: deal with errors
        // update model
        $updated = $this->resourceService()->update($this->getId(), $data);
        // return updated model
        return new LaravelCollection($updated['data']);
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
        // TODO: deal with errors
        // insert new items
        $inserted = $this->resourceService()->create($data);
        // return item
        return new LaravelCollection($inserted['data']);
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
        // attach item
        $attach = $this->resourceService()->attach($this->getId(), [
            'type' => $entity->get('resource_type'),
            'id' => $entity->get('id')
        ]);

        $relationships = $this->source['relationships'];
        $relationships[$entity->get('resource_type')]['data'] = array_merge($relationships[$entity->get('resource_type')]['data'],[[
            'type' => $entity->get('resource_type'),
            'id' => $entity->get('id')
        ]]);
        $this->source->put('relationships', $relationships);
    }
    /**
     * remove a relationship from the entities source
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
     * return the service to get api data
     *
     * @method resourceService
     *
     * @return App\Services\Api\AbstractApiService
     */
    protected function resourceService(){
        return new $this->resourceService;
    }
}
