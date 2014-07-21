<?php

class ApiController extends Controller {


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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($item = null, $contenttype = null, $content = null)
	{
		// default options
		$opts = $defaults = array(
			'format' => 'json'
		);
		// accepted formats
		$formats = array('json');
		// accepted parameters
		$parameters = array('limit','offset','fields','level','depth','language');
		
		if( $item != "" && $contenttype == "" )
		{
			$args = explode(".", $item);
			$args[0] !== "" ? $opts['item'] = $args[0] : "";
		}
		elseif( $contenttype != "" && $content == "" )
		{
			$args = explode(".", $contenttype);
			$args[0] !== "" ? $opts['contenttype'] = $args[0] : "";
			$opts['item'] = $item;
		}
		elseif( $contenttype != "" && $content != "" )
		{
			$args = explode(".", $content);
			$args[0] !== "" ? $opts['content'] = $args[0] : "";
			$opts['item'] = $item;
			$opts['contenttype'] = $contenttype;
		}
	
		// asign format
		isset($args[1]) && $args[1] !== "" ? $opts['format'] = $args[1] : "";
	
		// assign parameters
		foreach(Input::all() as $parameter => $value)
		{
			if( in_array($parameter, $parameters) )
			{
				$opts[$parameter] = $value;
			}
		}
		// merge defaults
		$opts['format'] = in_array($opts['format'], $formats) ? $opts['format'] : $formats[0];
		$opts = array_merge($defaults, $opts);
		
		// set language if given
		if( isset($opts['language']) && $opts['language'] != "" )
		{
			Config::set('content.locale', $opts['language']);
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
			elseif( !isset($opts['contenttype']) && isset($opts['pageonly']) && $opts['pageonly'] == true )
			{
				return Response::json(Content::getContent($opts['item']), 200);
			}
			elseif( !isset($opts['contenttype']) )
			{
				return Response::json(Content::getPage($opts['item']), 200);
			}
			elseif( isset($opts['contenttype']) && $opts['contenttype'] == 'posts' )
			{
				return Response::json(Content::getPosts($opts['item'], isset($opts['content']) ? $opts['content'] : ""), 200);
			}
		}

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
			$content = Content::getContent($id);

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
		//		//['config' => ['secretkey' => 'Lukas']
	}


}
