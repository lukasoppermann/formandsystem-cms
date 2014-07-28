<?php namespace App\Facades;

use Illuminate\Support\ServiceProvider;

class FormandsystemServiceProvider extends ServiceProvider {
	
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	/**
	 * Bind classes & register facades
	 */
	public function register()
  {
		/**
		 * Bind classes to app
		 */
    $this->app->bind('content', 'ContentModel');
    $this->app->bind('navigation', 'NavigationModel');
		/**
		 * Register Facades
		 */
    $this->app->booting(function()
    {
      $loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Content', '\App\Facades\Content');
			$loader->alias('Navigation', '\App\Facades\Navigation');
    });
  }

}