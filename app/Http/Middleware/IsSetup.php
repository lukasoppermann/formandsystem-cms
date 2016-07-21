<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Entities\User;

class IsSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!(new User($request->user()))->account()->isSetup() && !$request->is('settings/developers') && $request->isMethod('get')){
            return redirect('/settings/developers');
        }

        return $next($request);
    }
}
