<?php

namespace App\Entities;

use App\Entities\AbstractEntity;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

abstract class AbstractApiResourceEntity extends AbstractEntity
{

    protected $resourceService;
    protected $relationships = NULL;
    protected $links = NULL;

    public function __call($method, $args = [])
    {
        // automatically include relationships
        if($this->relationships !== NULL && $this->relationships->has($method)){
            // return call_user_func_array(array($this,'relatedEntities'), $args);
            return $this->relatedEntities($method, $args);
        }
    }
    /**
     * set an entity to new values from within
     *
     * @method setEntityToId
     *
     * @param  string        $id [description]
     */
    public function setEntityToId(string $id)
    {
        // try to get from cache
        if(\Cache::has($id)){
            $entity = \Cache::get($id);
        }else {
            $collection = new LaravelCollection($this->resourceService()->first('id',$id));

            if( !$collection->isEmpty() ){
                $entity = new $this($collection);
            }else{
                throw new \App\Exceptions\EmptyException();
            }
        }

        if(isset($entity) && $entity->items !== NULL){
            //
            $this->items = $entity->items;
            $this->links = $entity->links;
            //#
            $this->relationships = $entity->relationships;
        }else{
            throw new \App\Exceptions\EmptyException();
        }
    }
    /**
     * get id for current entity from source
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
     * return realted entities
     *
     * @method relatedEntities
     *
     * @param  Array          $relatedData [description]
     *
     * @return Illuminate\Support\Collection
     */
    public function relatedEntities($relatedType, $field = NULL, $key = NULL, $first = false)
    {
        if(is_array($field)){
            $key = isset($field[1]) ? $field[1] : NULL;
            $first = isset($field[2]) ? $field[2] : NULL;
            $field = isset($field[0]) ? $field[0] : NULL;
        }
        // if collection has not been retrieved
        if($this->relationships[$relatedType] === NULL){
            $service = '\App\Services\Api\\'.$this->getClassName().'Service';
            $related = (new $service)->relationship($this->getId(), $relatedType);
            if(isset($related['data'])){
                $this->relationships[$relatedType] = (new LaravelCollection($related['data']))->pluck('id');
                $this->cacheAsEntities($related['data']);
                $this->cacheAsEntities($related['included']);
            }
        }
        // build entities
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
        });
        // remove deleted items
        $data = $data->reject(function($item){
            return $item === NULL;
        });
        // get ids
        $newRelationships = $data->pluck('id')->map(function($item) use ($relatedType){
            return $item;
        });
        // update relationships
        $this->relationships->put($relatedType, $newRelationships);
        // update cache
        $this->cacheSelf();
        // return data
        return $this->collectionData($data, $field, $key, $first);
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
        $updated = $this->resourceService()->update($this->getId(), array_merge(['type' => $this->items['resource_type']], $data));
        if(isset($updated['data'])){
            // return updated model
            return new LaravelCollection($updated['data']);
        }
        \Log::error($updated);
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
        $attach = $this->resourceService()->attach($this->getId(), $entity->get('resource_type'), [
            'type' => $entity->get('resource_type'),
            'id' => $entity->get('id')
        ]);
        // add to relationships
        $this->relationships->get($entity->get('resource_type'))->push($entity->get('id'));
        // update cache
        $this->cacheSelf();
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
        // dettach item
        $this->resourceService()->attach($this->getId(), $entity->get('resource_type'), [
            'type' => $entity->get('resource_type'),
            'id' => $entity->get('id')
        ]);
    }
    /**
     * remove a relationship from the entities source
     *
     * @method removeRelationship
     *
     * @param  App\Entities\AbstractEntity  $entity [description]
     */
    protected function removeAllRelationships($type){
        // dettach all
        $response = $this->resourceService()->reattach($this->getId(), $type, [
            []
        ]);
        // add to relationships
        $this->relationships[$type] = new LaravelCollection([]);
        // update cache
        $this->cacheSelf();
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
    /**
     * return a link from the entity
     *
     * @method link
     *
     * @return string NULL
     */
    public function link($name)
    {
        if(isset($this->links[$name])){
            return $this->links[$name];
        }
        return NULL;
    }
}
