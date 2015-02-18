<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends AbstractController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$nav = \Api::stream('navigation')->get(['limit' => 100, 'language' => \Config::get('content.locale')])['data'];
		return view('page', ['content' => $nav[key($nav)]['content'][$this->language], 'nav_items' => $nav, 'template' => 'partials/menu-item' ]);
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
	public function show( $name )
	{
		$nav = \Api::stream('navigation')->get(['limit' => 100, 'language' => \Config::get('content.locale')])['data'];
		$page = \Api::pages($name)->get(['language' => $this->language])['data'];

		return view('page', ['content' => $page['content'][$this->language], 'nav_items' => $nav, 'template' => 'partials/menu-item']);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return $id;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
