<?php

namespace App\Entities;

use App\Models\User as UserModel;
use App\Entities\Account;
use App\Entities\AbstractModelEntity;
use Cache;
use Illuminate\Support\Collection as LaravelCollection;

class User extends AbstractModelEntity
{
    /**
     * determins if entity gets cached
     *
     * @var boolean
     */
    protected $cacheSelf = false;
    /**
     * model namespace or model instance
     *
     * @var string|Model
     */
    protected $model = '\App\Models\User';
    // TODO: add caching for User Listing view
    /**
     * get request user if current user, or from DB
     *
     * @method getModel
     *
     * @param  string   $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    //  public function getEntityFromId(string $id)
    //  {
    //     // try to get from cache
    //     if(\Auth::user()->id === $id){
    //         $model = \Auth::user();
    //     }
    //     else {
    //         $model = $this->getModel()->find($id);
    //     }
    //      // get from model
    //      return new $this($model);
    //  }
    public function setEntityToId(string $id)
    {
       // try to get from cache
       if(\Auth::user()->id === $id){
           $this->model = \Auth::user();
       }
       else {
           $this->model = $this->getModel()->find($id);
       }
       $this->items = $this->attributes($this->model);
        // get from model
        // return new $this($model);
    }
    /**
     * returns all accounts that a user is assosiated with
     *
     * @method accounts
     *
     * @return Illuminate\Support\Collection
     */
    public function accounts($field = NULL, $key = NULL, $first = false)
    {
        // get data
        $data = $this->getCacheOrRetrieve('Accounts', 'Account');
        // return collection
        return $this->collectionData($data, $field, $key, $first);
    }
    /**
     * get accounts from users relationship
     *
     * @method retrieveAccount
     *
     * @return Illuminate\Support\Collection
     */
    protected function retrieveAccounts()
    {
        return $this->getModel()->accounts;
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
        if($account = $this->accounts('id', config('app.active_account'), true)){
            return $account;
        }
        // if no account is selected return first account
        return $this->accounts()->first();
    }
    /**
     * prepare attributes
     *
     * @method attributes
     *
     * @param  mixed     $source [description]
     *
     * @return array
     */
    protected function attributes($model)
    {
        return $model->toArray();
    }
}
