<?php

class HomeController extends BaseController {
	/**
	* The layout that should be used for responses.
	*/
	protected $layout = 'content.index';
	
	/**
	* Show the homepage
	*/
	public function index()
	{
		$this->layout->title = 'Test';
		
		// load overview
		$this->layout->content = View::make('content.overview');
	}
	
	public function portfolio()
	{
		return View::make('home.portfolio');
	}

}