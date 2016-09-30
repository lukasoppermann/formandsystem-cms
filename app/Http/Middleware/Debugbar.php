<?php namespace App\Http\Middleware;

use Closure;

class Debugbar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app('debugbar')->disable();

        if (auth()->check() && auth()->user()->email === 'oppermann.lukas@gmail.com') {
            app('debugbar')->enable();
        }

        return $next($request);
    }
}
