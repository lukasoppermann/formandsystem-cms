<?php

namespace App\Entities;

use App\Models\User as UserModel;
use App\Entities\Account;
use App\Entities\AbstractModelEntity;
use Cache;
use Illuminate\Support\Collection as LaravelCollection;

class User extends AbstractModelEntity
{
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
    protected function getModel($id){
        if(\Auth::user()->id === $id){
            return \Auth::user();
        }
        // get user from DB
        return (new UserModel)->find($id);
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
        return new LaravelCollection($this->source->accounts);
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
    protected function attributes($source)
    {
        return $source;
    }
}
