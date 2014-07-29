<?php

class StreamapiController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::json(Navigation::getNested(), 200);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return Response::json('Yo', 200);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($item = null)
	{
		// default options
		$opts = $defaults = array(
			'format' => 'json',
			'language' => Config::get('content.locale', 'en')
		);

		// accepted formats
		$formats = array('json');

		// accepted parameters
		$parameters = array('limit','offset','fields','level','depth','lang','lang','pageonly','path');

		// if item is missing, throw exception
		if( $item == null)
		{
			throw new Exception('1 parameter needed, 0 where given.');
		}

		// get format
		$args = explode(".", $item);
		$args[0] !== "" ? $opts['item'] = $args[0] : "";
		isset($args[1]) && $args[1] !== "" ? $opts['format'] = $args[1] : "";
		$opts['format'] = in_array($opts['format'], $formats) ? $opts['format'] : $formats[0];

		// assign parameters
		foreach(Input::all() as $parameter => $value)
		{
			if( in_array($parameter, $parameters) )
			{
				$opts[$parameter] = $value;
			}
		}

		// merge defaults
		$opts = array_merge($defaults, $opts);

		// set language if given
		if( isset($opts['lang']) && $opts['lang'] != "" )
		{
			Config::set('content.locale', $opts['lang']);
		}
		
		// check for path parameter
		if( isset($opts['path']) && $opts['path'] != "" )
		{
			$opts['item'] = urldecode($opts['path']);
		}
		// navigation
		if( $opts['item'] == 'navigation' )
		{
			return Response::json(Navigation::getNavigation(), 200);
		}
		// page
		else
		{
			if( !isset($opts['item']) || $opts['item'] == "" )
			{
				return Response::json(Content::getFirst(), 200);
			}
			elseif( !isset($opts['pageonly']) || $opts['pageonly'] != true )
			{
				return Response::json(Content::getPage($opts['item']), 200);
			}
			elseif( isset($opts['pageonly']) && $opts['pageonly'] == true )
			{
				return Response::json(Content::getContent($opts['item']), 200);
			}
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id = null)
	{
		if( $id != null )
		{
			$content = Content::getPage($id);

			$content->title = Input::get('title');
			$content->data = Input::get('content');

			$content->save();
    
			return Response::json(array('message' => 'saved'), 200);
		}
		else
		{
			return Response::json(array('message' => 'ID needed to update content.'), 400);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return Response::json('Yo', 200);
		//		//['config' => ['secretkey' => 'Lukas']
	}


}
