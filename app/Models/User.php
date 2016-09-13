<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\CausesActivity;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Metable;

class User extends Authenticatable
{
    use Notifiable, HasRoles, UserHasTeams, Eloquence, Metable, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * checks if a user verified her email address
     * @method isVerified
     * @return bool
     */
    public function isVerified() : bool
    {
        return $this->verified === 1;
    }
}
