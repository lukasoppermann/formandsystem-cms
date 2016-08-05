<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


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

    }
}
