<?php

namespace App\Entities;

use App\Entities\AbstractApiResourceEntity;
use Illuminate\Support\Collection as LaravelCollection;

class Fragment extends AbstractApiResourceEntity
{
    /**
     * define which fragment types are defaults
     */
    protected $default_fragments = [
        'section',
        'image',
        'text',
        'dropdown',
        'input',
        'button',
        'collection',
    ];
    /**
     * the service class for this entity
     */
    protected $resourceService = '\App\Services\Api\FragmentService';
    /**
     * retrieve data and build collection
     *
     * @method __construct
     *
     * @param  mixed     $data [description]
     */
    public function __construct($data)
    {
        parent::__construct($data);
    }
    /**
     * transform attributes
     *
     * @method attributes
     *
     * @param  Array      $attributes
     *
     * @return array
     */
    protected function attributes($attributes)
    {
        // return attributes
        return [
            'id'                => $attributes['id'],
            'resource_type'     => $attributes['type'],
            'position'          => $attributes['attributes']['position'],
            'type'              => $attributes['attributes']['type'],
            'name'              => $attributes['attributes']['name'],
            'data'              => $this->jsonDecode($attributes['attributes']['data']),
            'meta'              => $attributes['attributes']['meta'],
            'created_at'        => $attributes['attributes']['created_at'],
            'is_trashed'        => $attributes['attributes']['is_trashed'],
        ];
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
        // CUSTOM ELEMENT
        if( !in_array($data['type'], $this->default_fragments) ){

            $blueprint = config('app.user')->account()->details('type','fragment')->where('name',$data['type'])->first();
            if( $blueprint === null ){
                return back();
            }
            // get add meta

            $meta = NULL;
            if(isset($blueprint['data']['meta']) && isset($blueprint['data']['meta']['meta'])){
                $meta = $blueprint['data']['meta']['meta'];
            }
            // create new element
            $data = [
                'type'      => $data['type'],
                'data'      => json_encode($blueprint['data']),
                'position'  => isset($data['position']) ? $data['position'] : 0,
                'meta'      => $meta
            ];
        // NORMAL ELEMENT
        }
        // TODO: deal with errors
        // insert new items
        $inserted = $this->resourceService()->create($data);
        if(isset($inserted['message'])){
            \Log::error("Error ".$inserted['status_code'].": ".$inserted['message']);
        }
        // return item
        return new LaravelCollection($inserted['data']);
    }
    /**
     * create a custom fragment and all subfragments
     *
     * @method newCustomFragment
     *
     * @param  App\Entities\AbstractEntity      $parent [description]
     * @param  string                           $type [description]
     *
     * @return model
     */
    protected function wasCreated()
    {
        if(isset($this->items['data']['elements'])){
            // add subfragments
            foreach($this->items['data']['elements'] as $position => $element){
                if(isset($element['name'])){
                    // create fragment
                    $subfragment = new \App\Entities\Fragment([
                        'type'      => $element['type'],
                        'name'      => $element['name'],
                        'position'  => $position,
                        'meta'      => isset($element['meta']) ? $element['meta'] : NULL,
                    ]);
                    // attach to parent
                    $this->attach($subfragment);
                }
            }
        }
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
        $this->fragments()->each(function($item){
            $item->delete();
        });
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

        if(isset($updated['data'])){
            // return updated model
            return new LaravelCollection($updated['data']);
        }
        \Log::error($updated);
    }
}
