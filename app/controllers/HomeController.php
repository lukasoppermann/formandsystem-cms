<?php

class HomeController extends BaseController {
	/**
	* The layout that should be used for responses.
	*/
	protected $layout = 'home.index';
	
	/**
	* Show the homepage
	*/
	public function index()
	{
		$this->layout->title = 'Test';
		
		// load about page
		$this->layout->about = View::make('home.about');
		// load portfolio
		$this->layout->portfolio = $this->portfolio();
		// load expertise
		$this->layout->expertise = View::make('home.expertise');
		// load philosophy
		$this->layout->philosophy = View::make('home.philosophy');
		// load contact
		$this->layout->contact = View::make('home.contact');
	}
	
	public function portfolio()
	{
		return View::make('home.portfolio');
	}

}