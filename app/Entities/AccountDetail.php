<?php

namespace App\Entities;

use App\Entities\AbstractModelEntity;
use App\Models\AccountDetail as AccountDetailModel;
use Cache;

class AccountDetail extends AbstractModelEntity
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
            if( !$detail = (new AccountDetailModel)->find($id) ){
                throw new \ErrorException('No '.get_class($this).' with ID: '.$id.' found.');
            }
            // store account in cache
            Cache::put($detail->id,$detail,1440);
        }
        // return model from cache
        return Cache::get($id);
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
