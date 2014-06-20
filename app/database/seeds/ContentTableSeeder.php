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
		
		DB::statement("ALTER TABLE `fs_content` AUTO_INCREMENT = 1;");
		
		DB::table('fs_content')->insert(array(
			array(
				'menu_id' => '1',
				'article_id' => '1',
				'menu_label' => 'Start',
				'link' => 'start',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'data' => json_encode(array(
					array(
						"class" => "section-01",
						"children" => array(
              array(
								"type" => "image",
								"column" => 3,
								"content" => array(
									"src" => "imagefile.png",
									"description" => "Some optional text"
								),
								"class" => "optional-classes"
							),
							array(
								"type" => "text",
								"column" => 2,
								"content" => "#Headline content is in markdown",
								"class" => "optional-classes"
							),
							array(
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
				'article_id' => '2',
				'menu_label' => 'Home',
				'link' => 'home',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'data' => json_encode(array(
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
				'article_id' => '3',
				'menu_label' => 'Blog',
				'link' => 'blog',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'data' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown","class": "optional-classes"}}}}'
			),
			array(
				'menu_id' => '3',
				'article_id' => '4',
				'menu_label' => 'Portfolio',
				'link' => 'portfolio',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'data' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown\nAnd a _little_ **Markdown**","class": "optional-classes"}}}}'
			),
			array(
				'menu_id' => '4',
				'article_id' => '5',
				'menu_label' => 'Contact',
				'link' => 'contact',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'data' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown","class": "optional-classes"}}}}'
			),
			array(
				'menu_id' => '5',
				'article_id' => '6',
				'menu_label' => 'Kontakt',
				'link' => 'kontakt',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'data' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown","class": "optional-classes"}}}}'
			),
			array(
				'menu_id' => '7',
				'article_id' => '7',
				'menu_label' => 'Kontakt',
				'link' => 'kontakt',
				'status' => '1',
				'language' => 'de',
				'type' => '1',
				'title' => 'Entry',
				'data' => '{"1":{"class":"section-01","content":{"0":{"type": "image","column": 3,"content": {"src": "imagefile.png","description": "Some optional text"},"class": "optional-classes"},"2":{"type": "text","column": 2,"content": "#Headline content is in markdown","class": "optional-classes"}}}}'
			),
		));
	}
    
}
