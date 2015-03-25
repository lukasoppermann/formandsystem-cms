<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends AbstractController {

	private $js_scope = 'editor';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$nav = \Api::stream('navigation')->get(['limit' => 100, 'language' => \Config::get('content.locale')])['data'];

		return view('page', ['content' => $nav[key($nav)]['content'][$this->language], 'items' => $nav, 'template' => 'partials/menu-item', 'js_scope' => $this->js_scope ]);
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

		return view('page', ['content' => $page['content'][$this->language], 'nav_items' => $nav, 'template' => 'partials/menu-item', 'js_scope' => $this->js_scope]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$sections = json_decode($request->input('data'), true);
		// TODO: move json orga into service
		foreach($sections as $section)
		{
			$columns = [];
			// build children array
			foreach($section['children'] as $child)
			{
				if( isset($child['fragmentId']) )
				{
					$columns[] = [
						'fragment' 	=> $child['fragmentId'],
						'columns' 		=> $child['column'],
						'offset' 		=> $child['offset'],
					];

					$fragments[$child['fragmentId']] = [
						'key' => $child['fragmentKey'],
						'type' => $child['fragmentType'],
						'data' => [
							'text' => $child['fragmentContent']
						]
					];
				}
			}

			$data[] = [
				'class' 	=> $section['class'],
				'link' 		=> $section['link'],
				'columns' => $columns,
			];
		}

		$page = [
			'article_id'	=> 1,
			'language' 		=> 'de',
			'data' 				=> $data,
			'menu_label' 	=> 'Home',
			'link'				=> 'home',
			'tags' 				=> ['test','Test']
		];

		foreach( $fragments as $id => $fragment  )
		{
			\Api::fragment($id)->put($fragment);
		}
		// return $page;
		return \Api::pages($id)->put($page);
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
