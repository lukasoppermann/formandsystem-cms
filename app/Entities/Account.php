<?php

namespace App\Entities;

use App\Entities\AbstractModelEntity;
use App\Entities\AccountDetail;
use App\Models\Account;
use App\Services\Api\MetadetailService;
use Illuminate\Support\Collection as LaravelCollection;
use Cache;

class Account extends AbstractModelEntity
{
    protected $cacheSource = true;
    /**
     * get model for this entity
     *
     * @method getModel
     *
     * @param  string   $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function getModel($id){
        if(!Cache::has($id)){
            // throw expection if account is not found
            if( config('app.user') === NULL
                || config('app.user')->source->accounts === NULL
                || !$account = config('app.user')->source->accounts->where('id',$id)->first()
            ){
                throw new \ErrorException('No account with ID: '.$id.' found.');
            }
            // store account in cache
            Cache::put($account->id,$account,1440);
        }
        // return model from cache
        return Cache::get($id);
    }
    /**
     * get details for the given account
     *
     * @method details
     *
     * @return Illuminate\Support\Collection
     */
    public function details()
    {
        // build cache name
        $cache_name = $this->getCacheName('AccountDetail');
        // check cache
        if(!Cache::has($cache_name)){
            // get all items from model
            $details = $this->source->accountdetails;
            foreach($details as $item){
                $ids[] = $item->id;
                // cache to reduce DB queries
                Cache::put($item->id, $item, 1440);
            }
            // store in cache
            Cache::put($cache_name, new LaravelCollection($ids), 1440);
        }
        $cached = Cache::get($cache_name);
        $count = count($cached);
        // return from cache
        $details = (new LaravelCollection(
            $cached->map(function($item){
                try{
                    return new AccountDetail($item);
                }catch(\ErrorException $e){
                    return NULL;
                }
            })->reject(function($item){
                return empty($item);
            })
        ))->keyBy('id');
        // reset cache
        if(count($details) !== $count){
            Cache::put($cache_name, new LaravelCollection($details->keys()), 1440);
        }
        // return collection
        return $details;
    }
    public function metadetails()
    {
        return (new MetadetailService)->find('type',['site_url','dir_images','analytics_code','analytics_anonymize_ip','site_name']);
    }
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
