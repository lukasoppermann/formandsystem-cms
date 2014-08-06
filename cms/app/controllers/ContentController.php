<?php

class ContentController extends \BaseController {

	protected $layout = 'content.template';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Redirect::route('content.create')->with(array('position' => 1, 'language' => Config::get('content.locale')));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create( $id = null )
	{
		$this->layout->content = View::make('content.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// create new entry
	  $stored = $this->content->create(Input::all());
 	 	// check if entry is stored correctly
	  if($stored->isSaved())
	  {
	    return Redirect::route('/content/'.$stored->id)
	      ->with('flash', 'Your new page has been created');
	  }
 	 	// on error
	  return Redirect::route('content.create')
	    ->withInput()
	    ->withErrors($stored->errors());
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) // this is the edit form
	{
		if( $data = Api::get($id.'.json?language='.Config::get('content.locale')) )
		{
			$this->layout->content = View::make('content.edit')->with('content', $data);
		}
		else
		{
	    return Redirect::route('content.index')->with('error', (object) ['message' => 'This page does not exist. More info....']);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$content = Content::getPage($id);
		
		$content->title = Input::get('title');
		$content->data = Input::get('content');
		
		return Api::put($id,[
			'body' => Input::all()
		]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//['config' => ['secretkey' => 'Lukas']
	}
	

}