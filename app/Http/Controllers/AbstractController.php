<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Config;

abstract class AbstractController extends Controller {

	public $languages;
	public $language;

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		// @TODO: needs check for if api returns false
		// foreach( \Api::settings()->get()['data'] as $group => $items )
		// {
		// 	foreach($items as $item)
		// 	{
		// 		$settings[$group][$item['key']] = $item;
		// 	}
		// 	Config::set('settings.'.$group, $settings[$group] );
		// }

		$this->languages = ['de','en','fr'];
		$this->language  = 'de';

		Config::set('content.locale', $this->language );
	}

}
