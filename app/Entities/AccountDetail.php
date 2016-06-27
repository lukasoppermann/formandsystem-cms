<?php

namespace App\Entities;

use App\Entities\AbstractEntity;
use App\Models\AccountDetail as AccountDetailModel;
use Cache;

class AccountDetail extends AbstractEntity
{
    protected $cacheModel = true;
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
            if( !$detail = (new AccountDetailModel)->find($id) ){
                throw new \ErrorException('No '.get_class($this).' with ID: '.$id.' found.');
            }
            // store account in cache
            Cache::put($detail->id,$detail,1440);
        }
        // return model from cache
        return Cache::get($id);
    }
}
