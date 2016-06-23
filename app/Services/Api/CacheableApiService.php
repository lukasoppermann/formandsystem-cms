<?php

namespace App\Services\Api;

use Cache;
use Auth;

abstract class CacheableApiService extends AbstractApiService
{
    // /**
    //  * time for which a service is cached in minutes
    //  *
    //  * @var int
    //  */
    // protected $cache_minutes = 14400; // 1 day
    // /**
    //  * [storeInCache description]
    //  *
    //  * @method storeInCache
    //  *
    //  * @return boolean
    //  */
    // public function storeInCache($data, $suffix = NULL)
    // {
    //     // get cache list
    //     $cacheList = (array)Cache::get($this->cacheName('cacheList'));
    //     // check if exists in cache list
    //     if (!in_array($this->cacheName($suffix), $cacheList)){
    //         // store in cache list
    //         $cacheList[] = $this->cacheName($suffix);
    //         // dd(Cache::get($this->cacheName('cacheList')));
    //         Cache::forget($this->cacheName('cacheList'));
    //         // dd(Cache::get($this->cacheName('cacheList')));
    //         Cache::forever($this->cacheName('cacheList'), $cacheList);
    //         // dd(Cache::get($this->cacheName('cacheList')));
    //     }
    //     // put to cache
    //     return Cache::put($this->cacheName($suffix), $data, $this->cache_minutes);
    // }
    // /**
    //  * get a cache or return false
    //  *
    //  * @method getFromCache
    //  *
    //  * @return Mixed
    //  */
    // public function getFromCache($suffix = NULL)
    // {
    //     if(Cache::has($this->cacheName($suffix))){
    //         return Cache::get($this->cacheName($suffix));
    //     }
    //     return false;
    // }
    // /**
    //  * removes cache for current service
    //  *
    //  * @method deleteFromCache
    //  *
    //  * @return boolean
    //  */
    // public function deleteFromCache($suffix = NULL)
    // {
    //     return Cache::forget($this->cacheName($suffix));
    // }
    // /**
    //  * removes all of current service's caches
    //  *
    //  * @method clearCache
    //  *
    //  * @return boolean
    //  */
    public function clearCache($endpoint = NULL)
    {
        // foreach((array)Cache::get($this->cacheName('cacheList', $endpoint)) as $cache){
        //     Cache::forget($cache);
        // }
        // Cache::forget($this->cacheName('cacheList', $endpoint));
        // //
        // return true;
    }
    // /**
    //  * returns current cache name
    //  *
    //  * @method cacheName
    //  *
    //  * @return string
    //  */
    // public function cacheName($suffix = NULL, $endpoint = NULL)
    // {
    //     if($endpoint === NULL){
    //         $endpoint = $this->endpoint;
    //     }
    //     // return name
    //     return Auth::user()->id.'-'.$endpoint.$suffix;
    // }
    // /**
    //  * get all items on all pages
    //  *
    //  * @method all
    //  *
    //  * @param  Array $param
    //  *
    //  * @return Illuminate\Support\Collection
    //  */
    // public function all(Array $param = NULL){
    //     return $this->callFunctionWithCache('all', func_get_args());
    // }
    // /**
    //  * find items by filter
    //  *
    //  * @method find
    //  *
    //  * @param  string $filter
    //  * @param  string|array $values
    //  * @param  array $param
    //  *
    //  * @return Illuminate\Support\Collection
    //  */
    // public function find($filter = NULL, $values = NULL, Array $param = []){
    //     return $this->callFunctionWithCache('find', func_get_args());
    // }
    // /**
    //  * create
    //  *
    //  * @method create
    //  *
    //  * @return EXCEPTION|array
    //  */
    // public function create(Array $data){
    //     // delete all caches
    //     $this->clearCache();
    //     // call parent fn
    //     return call_user_func_array("parent::create", func_get_args());
    // }
    // /**
    //  * update
    //  *
    //  * @method update
    //  *
    //  * @return EXCEPTION|array
    //  */
    // public function update($id, Array $data){
    //     // delete all caches
    //     $this->clearCache();
    //     // call parent fn
    //     return call_user_func_array("parent::update", func_get_args());
    // }
    // /**
    //  * delete an item by id
    //  *
    //  * @method delete
    //  *
    //  * @param string $id
    //  *
    //  * @return boolean
    //  */
    // public function delete($id = NULL){
    //     // delete all caches
    //     $this->clearCache();
    //     // call parent fn
    //     return call_user_func_array("parent::delete", func_get_args());
    // }
    // /**
    //  * call a function but with cache
    //  *
    //  * @method callFunctionWithCache
    //  *
    //  * @param  string                $fn   name of the function to call
    //  * @param  array                 $args arguments of the function call
    //  *
    //  * @return mixed
    //  */
    // public function callFunctionWithCache($fn, $args)
    // {
    //     // get from cache if available
    //     if($cached = $this->getFromCache(http_build_query($args))){
    //         return $cached;
    //     }
    //     // otherwise store in cache and return
    //     $data = call_user_func_array("parent::$fn", $args);
    //     // store in cache
    //     $this->storeInCache($data, http_build_query($args));
    //     // return data
    //     return $data;
    // }
}
