<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\CausesActivity;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Metable;
use Jrean\UserVerification\Traits\UserVerification;
use App\Models\Presenters\UserPresenter;

class User extends Authenticatable
{
    use Notifiable, HasRoles, UserHasTeams, Eloquence, Metable, CausesActivity, UserVerification, UserPresenter;

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
     * returns last email verification request
     * @method lastVerificationEmail
     * @return Carbon
     */
    public function lastVerificationEmail()
    {
        return  collect($this->activity()->inLog('email verification')->get())
                ->sortByDesc('created_at')
                ->pluck('created_at')
                ->first();
    }

}
