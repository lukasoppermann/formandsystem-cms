<?php

namespace App\Services\Api;

use App\Services\AbstractService;
use Illuminate\Support\Collection as LaravelCollection;

abstract class AbstractApiService extends AbstractService
{
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
        // TODO: remove get entirely
        return $this->find('id',$ids,$param);
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
        // missing parameters
        if($filter === NULL || $values === NULL){
            return NULL;
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
            return [];
        }
        return $items;
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
        // TODO: use limit in api
        // get result
        $results = $this->find($filter, $values, $param)['data'];
        // return first item or NULL
        return count($results) === 0 ? NULL : array_values($results)[0];
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
        $response = $this->api(config('app.user_client'))->post('/'.$this->endpoint, [
            'type'       => $this->endpoint,
            'attributes' => $data,
        ]);
        // return response
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
        $response = $this->api(config('app.user_client'))->patch('/'.$this->endpoint.'/'.$id, [
            'type' => $this->endpoint,
            'id'   => $id,
            'attributes' => $data,
        ]);
        // return response
        return $response;
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
        if(!$this->api(config('app.user_client'))->delete('/'.$this->endpoint.'/'.$id)){
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
        $response = $this->api(config('app.user_client'))->get($url);
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
     * attach a relationship to an item
     *
     * @method attach
     *
     * @param  string $id      resource id
     * @param  Array  $related [description]
     *
     * @return [type]
     */
    public function attach($id, Array $related)
    {
        // dd('Attach in API fails due to now not working with Many to Many!!!!!!!!!');
        $attach = $this->api(config('app.user_client'))->post('/'.$this->endpoint.'/'.$id.'/relationships/'.$related['type'], [
            [
                'type'  => $related['type'],
                'id'    => $related['id'],
            ]
        ]);

        return $attach;
    }
    /**
     * get a relationship
     *
     * @method relationship
     *
     * @param  string       $value [description]
     *
     * @return array
     */
    public function relationship($id, $relationship)
    {
        $url = trim('/'.$this->endpoint.'/'.$id.'/'.$relationship);
        // get collection
        if( !$items = $this->getAllItems($url) ){
            return [];
        }
        // return related items
        return $items;
    }

}
