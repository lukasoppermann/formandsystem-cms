<?php

class ContentController extends BaseController {
	// default template
	protected $layout = 'content.template';
	/**
	* Show the homepage
	*/
	public function index($lang = null, $link = null)
	{
		
		if( (isset($lang) || $lang !== null ) && ( isset($link) || $link !== null) )
		{
			$cont = new Content;
			$content = $cont->getByLink($link, $lang);
			Optimization::js(array('codemirror','mark'));
			// $this->layout->title = "Editing: $content['title']";
			$this->layout->content = View::make('content.edit')->with('content', $content);
		}
		else
		{
			// define $data array
			$data = array();
			if( (isset($lang) || $lang !== null ) || ( isset($link) || $link !== null) )
			{
				// $this->layout->title = Lang::get('errors.entry-404');
				$data = array('errorCode' => 'entry-404');
			}
				
			$this->layout->content = View::make('content.overview', $data);
		}
	}
	
	public function portfolio()
	{
		return View::make('home.portfolio');
	}

}