<?php

namespace App\Entities;

use App\Entities\AbstractEntity;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractApiResourceEntity extends AbstractEntity
{
    protected $resourceService;

    public function __call($method, $args)
    {
        // automatically include relationships
        if(array_key_exists($method, $this->source['relationships']) ){
            return $this->relatedEntities($method);
        }
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
        if($source === NULL && !isset($this->source)){
            return FALSE;
        }

        if($source === NULL){
            $source = $this->source;
        }

        return $source->get('id');
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
        if(!is_a($source, 'Illuminate\Support\Collection')){
            return $this->getData($source);
        }
        // return source
        return $source;
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
        $data = (new LaravelCollection($this->source['relationships'][$relatedType]['data']))->map(function($item){
            // get entity class
            $entity = '\App\Entities\\'.ucfirst(substr($item['type'],0 ,-1));
            // return entity if valid
            try{
                if(class_exists($entity)){
                    return new $entity($item['id']);
                }
            }catch(\App\Exceptions\EmptyException $e){
                return NULL;
            }
        })->reject(function($item){
            return empty($item);
        });
        $relationships = $this->source['relationships'];
        $relationships[$relatedType]['data'] = $data->pluck('id')->map(function($item) use ($relatedType){
            return [
                'type' => $relatedType,
                'id'   => $item,
            ];
        });

        $this->source->put('relationships', $relationships);
        $this->cacheSource($this->source);
        // return
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

        $this->cacheSource($this->source);
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
     * return thje service to get api data
     *
     * @method resourceService
     *
     * @return App\Services\Api\AbsrtactApiService
     */
    abstract protected function resourceService();
}
