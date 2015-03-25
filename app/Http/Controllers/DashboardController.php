<?php namespace App\Http\Controllers;

use \Config;

class DashboardController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
		// TODO: change language logic to
		Config::set('content.languages', array('de','en','fr'));
		// set local if not defined
		if( !Config::get('content.locale') )
		{
			Config::set('content.locale', array_values(Config::get('content.languages'))[0] );
		}
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('dashboard', ['items' =>
			[
				[
					'label' => 'Content',
					'link'  => '/',
					'icon'  => 'icon-page'
				],
				[
					'label' => 'Fragments',
					'link'  => '/',
					'icon'  => 'icon-fragment'
				],
				[
					'label' => 'Media',
					'link'  => '/',
					'icon'  => 'icon-media'
				],
				[
					'label' => 'Settings',
					'link'  => '/',
					'icon'  => 'icon-settings'
				],
				[
					'label' => 'Users',
					'link'  => '/',
					'icon'  => 'icon-users'
				],
				[
					'label' => 'Lukas Oppermann',
					'link'  => '/',
					'icon'  => 'icon-user'
				]
			],
			'template' => 'partials/main-menu-item'
		]);
	}

}
