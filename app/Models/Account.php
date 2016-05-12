<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends BaseModel
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
    protected $fillable = ['id','name','client_id','client_secret'];
    /**
     * The fragments that belong to the fragment.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
