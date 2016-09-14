<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('Nav', function ($app) {
            return new \App\Services\NavigationService($app['Illuminate\Http\Request']);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // if (!auth()->user()->email === 'oppermann.lukas@gmail.com') {
        //     $this->app->make('config')->set('debugbar.enabled', false);
        //     $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        //     $this->app->register(\GuzzleHttp\Profiling\Debugbar\Support\Laravel\ServiceProvider::class);
        // } else {
            $this->app->make('config')->set('debugbar.enabled', true);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->register(\GuzzleHttp\Profiling\Debugbar\Support\Laravel\ServiceProvider::class);
        // }
    }
}
