<?php

namespace App\Entities;

use App\Models\User;
use App\Entities\Account;
use App\Entities\AbstractEntity;
use Cache;
use Illuminate\Support\Collection as LaravelCollection;

class User extends AbstractEntity
{
    /**
     * get request user if current user, or from DB
     *
     * @method getModel
     *
     * @param  string   $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function getModel($id){
        if(\Auth::user()->id === $id){
            return \Auth::user();
        }
        // get user from DB
        return (new User)->find($id);
    }
    /**
     * returns all accounts that a user is assosiated with
     *
     * @method accounts
     *
     * @return Illuminate\Support\Collection
     */
    public function accounts()
    {
        // build cache name
        $cache_name = $this->getCacheName('account_ids');
        // check cache
        if(!Cache::has($cache_name)){
            // get all items from model
            foreach($this->model->accounts as $item){
                $ids[] = $item->id;
            }
            // store in cache
            Cache::put($cache_name, new LaravelCollection($ids), 1440);
        }
        // return from cache
        return new LaravelCollection(
            Cache::get($cache_name)->map(function($item){
                return new Account($item);
            })->keyBy('id')
        );
    }
    /**
     * current active account
     *
     * @method account
     *
     * @return App\Entities\Account
     */
    public function account()
    {
        // return specified user account
        if($account = $this->accounts()->get(config('app.active_account')) ){
            return $account;
        }
        // if no account is selected return first account
        return $this->accounts()->first();
    }
}
