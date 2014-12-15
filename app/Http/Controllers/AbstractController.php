<?php namespace App\Http\Controllers;

use App\Http\Requests;
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
		$this->languages = ['de','en','fr'];
		$this->language  = 'de';

		Config::set('content.locale', $this->language );
	}

}
