<?php

namespace App\Models;
use Illuminate\Support\Collection as LaravelCollection;


class AccountDetail extends BaseModel
{
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
    protected $fillable = ['id','type','name','data'];
    /**
     * Get data
     *
     * @param  string  $value
     * @return string
     */
    public function getDataAttribute($value)
    {
        if(is_array(json_decode($value, true))){
            return new LaravelCollection(json_decode($value, true));
        }
        return $value;
    }
    /**
     * The fragments that belong to the fragment.
     */
    public function accounts()
    {
        return $this->belongsToMany('App\Models\Account');
    }
}
