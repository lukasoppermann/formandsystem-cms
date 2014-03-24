<?php

class ContentTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('fs_content')->delete();
		
		DB::table('fs_content')->insert(array(
			array(
				'menu_id' => '1',
				'menu_label' => 'Start',
				'link' => '/start',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => json_encode(array(
					"1" => array(
						"class" => "section-01",
						"content" => array(
							"1" => array(
								"type" => "image",
								"column" => 3,
								"content" => array(
									"src" => "imagefile.png",
									"description" => "Some optional text"
								),
								"class" => "optional-classes"
							),
							"2" => array(
								"type" => "text",
								"column" => 2,
								"content" => "#Headline content is in markdown",
								"class" => "optional-classes"
							),
							"3" => array(
								"type" => "text",
								"column" => 2,
								"content" => "This is real **markdown** copy.",
								"class" => "optional-classes"
							)
						)
					)
				))
			),
			array(
				'menu_id' => '6',
				'menu_label' => 'Home',
				'link' => '/home',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => json_encode(array(
					"1" => array(
						"class" => "section-01",
						"content" => array(
							"1" => array(
								"type" => "image",
								"column" => 3,
								"content" => array(
									"src" => "imagefile.png",
									"description" => "Some optional text"
								),
								"class" => "optional-classes"
							),
							"2" => array(
								"type" => "text",
								"column" => 2,
								"content" => "#Headline content is in markdown",
								"class" => "optional-classes"
							),
							"3" => array(
								"type" => "text",
								"column" => 2,
								"content" => "This is real **markdown** copy.",
								"class" => "optional-classes"
							)
						)
					)
				))
			),
			array(
				'menu_id' => '2',
				'menu_label' => 'Blog',
				'link' => '/blog',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown","class": "optional-classes"}}}}'
			),
			array(
				'menu_id' => '3',
				'menu_label' => 'Portfolio',
				'link' => '/portfolio',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown\nAnd a _little_ **Markdown**","class": "optional-classes"}}}}'
			),
			array(
				'menu_id' => '4',
				'menu_label' => 'Contact',
				'link' => '/contact',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown","class": "optional-classes"}}}}'
			),
			array(
				'menu_id' => '5',
				'menu_label' => 'Kontakt',
				'link' => '/kontakt',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown","class": "optional-classes"}}}}'
			),
		));
	}
    
}
