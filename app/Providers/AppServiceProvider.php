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
        // if (\DB::connection() instanceof \Illuminate\Database\SQLiteConnection) {
        //     \DB::statement(\DB::raw('PRAGMA foreign_keys=1'));
        // }
        // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        // $loader->alias('Nav', 'App\Services\NavigationService');
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
