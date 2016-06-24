<?php

namespace App\Services\Api;

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
        $url = trim('/'.$this->endpoint.'?'.trim($this->parameters($param),'&'),'?');
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
            return NULL;
        }
        // turn $ids into array if not
        $many = false;
        is_array($ids) ? $many = true : $ids = [$ids];
        // build url
        $url = '/'.$this->endpoint.'?filter[id]='.trim(trim(implode(',',$ids),',').'&'.$this->parameters($param),'&');
        // get items
        if( !$items = $this->getAllItems($url) ){
            // return empty collection on error
            return NULL;
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
        if(!is_array($values)){
            $values = [[$values]]; // double array needed!
        }elseif( !is_array($values[key($values)]) ){
            $values = [$values];
        }
        // indexed array
        $values = array_values($values);
        $filter = is_array($filter) ? array_values($filter) : [$filter];
        $filters = "";
        // build filters
        foreach( $filter as $key => $filtername){
            $filters .= '&filter['.$filtername.']='.trim(implode(',',$values[$key]),',');
        }
        // build url
        $url = '/'.$this->endpoint.'?'.trim($filters.'&'.$this->parameters($param),'&');
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
        $results = $this->find($filter, $values, $param);
        return $results->first() === NULL ? new LaravelCollection() : $results->first();
    }
    /**
     * create
     *
     * @method create
     *
     * @return EXCEPTION|array
     */
    public function create(Array $data){
        // TODO: handle errors
        // make api call
        $response = $this->api($this->client)->post('/'.$this->endpoint, [
            'type'       => $this->endpoint,
            'attributes' => $data,
        ]);

        return $response;
    }
    /**
     * update
     *
     * @method update
     *
     * @return EXCEPTION|array
     */
    public function update($id, Array $data){
        // TODO: handle errors
        // make api call
        $response = $this->api($this->client)->patch('/'.$this->endpoint.'/'.$id, [
            'type' => $this->endpoint,
            'id'   => $id,
            'attributes' => $data,
        ]);
        // error
        if(!isset($response['data'])){
            return $response;
        }
        return $response;
        // return new $this->entity($response['data'], $response['data']['included']);
    }
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
            // add only
            if(isset($parameters['only']) && count($parameters['only']) > 0){
                $param_string .= '&'.$this->excludes($parameters['only']);
            }
            // add excludes
            if(isset($parameters['excludes']) && count($parameters['excludes']) > 0){
                $param_string .= '&exclude='.implode(',',$parameters['excludes']);
            }
            // add includes
            if(isset($parameters['includes']) && count($parameters['includes']) > 0){
                $param_string .= '&include='.implode(',',(array)$parameters['includes']);
            }
        }
        // return parameters string
        return !isset($param_string) ? NULL : trim($param_string,'&');
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
            \Log::error($e);
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
            \Log::error('Error '.$response['status_code'].' for '.$url.': '.$response['message']);
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
