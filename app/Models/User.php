<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    /**
     * If uuid is used instead of autoincementing id
     *
     * @var bool
     */
    protected $uuid = true;
    /**
     * Indicates if the model should force an auto-incrementeing id.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $model = new static($attributes);
        // add uuid
        if( $model->uuid === true ){

            $model->incrementing = false;
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        }
        $model->save();

        return $model;
    }
    /**
     * The fragments that belong to the fragment.
     */
    public function accounts()
    {
        return $this->belongsToMany('App\Models\Account');
    }
}
