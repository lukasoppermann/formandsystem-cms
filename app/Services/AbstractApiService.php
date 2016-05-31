<?php

namespace App\Services;

use App\Services\AbstractService;
use Illuminate\Support\Collection as LaravelCollection;

abstract class AbstractApiService extends AbstractService
{
    /**
     * get all items on all pages
     *
     * @method all
     *
     * @param  Array $param
     *
     * @return Illuminate\Support\Collection
     */
    public function all(Array $param = NULL){
        // prepare request url
        $url = trim('/'.$this->endpoint.'?'.$this->parameters($param),'?');
        // get collection
        if( !$items = $this->getAllItems($url) ){
            // return empty collection on error
            return new LaravelCollection();
        }
        // success
        $entities = new LaravelCollection();
        foreach($items['data'] as $item){
            $entities->push(new $this->entity($item, $items['included']));
        }
        // return
        return $entities;
    }
    /**
     * get items by id
     *
     * @method get
     *
     * @param  string|array $ids
     * @param  array $param
     *
     * @return Illuminate\Support\Collection
     */
    public function get($ids = NULL, Array $param = []){
        // no ids provided
        if($ids === NULL){
            return new LaravelCollection();
        }
        // turn $ids into array if not
        $many = false;
        is_array($ids) ? $many = true : $ids = [$ids];
        // build url
        $url = '/'.$this->endpoint.'?filter[id]='.trim(implode(',',$ids),',').$this->parameters($param);
        // get items
        if( !$items = $this->getAllItems($url) ){
            // return empty collection on error
            return new LaravelCollection();
        }
        // success
        $entities = new LaravelCollection();
        foreach($items['data'] as $item){
            $entities->push(new $this->entity($item, $items['included']));
        }
        if( $many !== true){
            $entities = $entities->first();
        }
        // return
        return $entities;
    }
    /**
     * find items by filter
     *
     * @method find
     *
     * @param  string $filter
     * @param  string|array $values
     * @param  array $param
     *
     * @return Illuminate\Support\Collection
     */
    public function find($filter = NULL, $values = NULL, Array $param = []){
        // no ids provided
        if($filter === NULL || $values === NULL){
            return new LaravelCollection();
        }
        // turn $values into array if not
        is_array($values) ?: $values = [$values];
        // build url
        $url = '/'.$this->endpoint.'?filter['.$filter.']='.trim(implode(',',$values),',').$this->parameters($param);
        // return
        if( !$items = $this->getAllItems($url) ){
            // return empty collection on error
            return new LaravelCollection();
        }
        // success
        $entities = new LaravelCollection();
        foreach($items['data'] as $item){
            $entities->push(new $this->entity($item, $items['included']));
        }
        // return
        return $entities;
    }
    /**
     * returns first result from find query
     *
     * @method first
     *
     * @param  string $filter
     * @param  string|array $values
     * @param  array $param
     *
     * @return \App\Entities\*
     */
    public function first($filter = NULL, $values = NULL, Array $param = [])
    {
        return $this->find($filter, $values, $param)[0];
    }
    // public abstract function create(Array $data);
    // public abstract function update($id, Array $data);
    /**
     * delete an item by id
     *
     * @method delete
     *
     * @param string $id
     *
     * @return boolean
     */
    public function delete($id = NULL){
        // return false if no id provided
        if($id === NULL){
            return false;
        }
        // try deleting
        if(!$this->api($this->client)->delete('/'.$this->endpoint.'/'.$id)){
            return true;
        }
        // no deletion
        return false;
    }
    /**
     * build parameters and excludes url parameters
     *
     * @method parameters
     *
     * @param  array          $parameters
     *
     * @return string
     */
    public function parameters($parameters = NULL)
    {
        if($parameters !== NULL && count($parameters) > 0){
            // get parameter string
            $param_string = !isset($parameters['parameters']) ? NULL : $parameters['parameters'];
            // add excludes
            if(isset($parameters['includes']) && $parameters['includes'] !== true){
                $param_string .= '&'.$this->excludes($parameters['includes']);
            }
        }
        // return parameters string
        return !isset($param_string) ? NULL : '&'.trim($param_string,'&');
    }
    /**
     * build excludes url parameters
     *
     * @method excludes
     *
     * @param  boolean|array   $includes
     *
     * @return string
     */
    public function excludes($includes = true)
    {
        // includes are missing
        if(!isset($this->includes)){
            return;
        }
        // get excludes
        if($includes === false){
            return '&exclude='.implode(',',$this->includes);
        }
        elseif(is_array($includes)){
            $excludes = array_diff($this->includes, $includes);
            return '&exclude='.implode(',',$excludes).'&include='.implode(',',$includes);
        }
    }
    /**
     * get all items from all pages of a collection
     *
     * @method getAllItems
     *
     * @param  string       $url
     *
     * @return array
     */
    protected function getAllItems($url)
    {
        // set $items array, which will be added to
        $items = [
            'data' => [],
            'included' => [],
        ];
        // try to get items
        try{
            $this->getWhileNext($items, $url);
            // return all items
            return $items;
        }catch(\Exception $e){
            return false;
        }
    }
    /**
     * get additonal items if next link is present
     *
     * @method getWhileNext
     *
     * @param  array       $items
     * @param  string       $url
     *
     * @return array
     */
    protected function getWhileNext(&$items, $url)
    {
        // make request
        $response = $this->api($this->client)->get($url);
        // error handling
        if( isset($response['status_code']) ){
            \Log::debug('Error '.$response['status_code'].' for '.$url.': '.$response['message']);
            throw new \Exception('Api Request failed.');
        }
        // merge items
        $items['data'] = array_merge(array_values($items['data']), array_values($response['data']));
        if(isset($response['included'])){
            // combine included  values
            $items['included'] = array_merge(array_values($items['included']), array_values($response['included']));
        }
        // move on to next page if it exists
        if( isset($response['links']['next']) ){
            $this->getWhileNext($items, $response['links']['next']);
        }
    }
    /**
     * add all related items of type $type to page
     *
     * @method addIncluded
     * @param  string        $type
     * @param  array         $page
     * @param  array         $included
     */
    public function addIncluded($type, $page, $included = NULL)
    {
        // empty array if not related data
        if(count($included) === 0 || count($page['relationships'][$type]['data']) === 0){
            return [];
        }
        // return all related item
        $ids = array_column($page['relationships'][$type]['data'], 'id');
        foreach($ids as $id){
            // TODO: add resource items so that relatinships are included
            $items[] = $included[array_search($id, array_column($included, 'id'))];
        }
        return $items;
    }
}
