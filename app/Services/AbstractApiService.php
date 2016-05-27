<?php

namespace App\Services;

use App\Services\AbstractService;

abstract class AbstractApiService extends AbstractService
{
    /**
     * build parameters and excludes url parameters
     *
     * @method parameters
     *
     * @param  string          $parameters
     * @param  boolean|array   $includes
     *
     * @return string
     */
    public function parameters($parameters = NULL, $includes = true)
    {
        return rtrim('&'.$parameters.$this->excludes($includes),'&');
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
            return '&exclude='.implode(',',$excludes);
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
        $this->getWhileNext($items, $url);
        // return all items
        return $items;
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
