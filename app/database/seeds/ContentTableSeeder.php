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
				'status' => '1',
				'language' => 'de',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{0:{class:"section-01",content:{0:{type: "image",column: 3,content: {src: "imagefile.png",description: "Some optional text"},class: "optional-classes"},1:{type: "text",column: 2,content: "#Headline 
content is in markdown",class: "optional-classes"}}}'
			),
			array(
				'menu_id' => '1',
				'menu_label' => 'Home',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{0:{type: "image",column: 3,content: {src: "imagefile.png",description: "Some optional text"},class: "optional-classes"},1:{type: "text",column: 2,content: "#Headline 
content is in markdown",class: "optional-classes"}}'
			),
			array(
				'menu_id' => '2',
				'menu_label' => 'Blog',
				'status' => '1',
				'language' => 'de',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{0:{type: "image",column: 3,content: {src: "imagefile.png",description: "Some optional text"},class: "optional-classes"},1:{type: "text",column: 2,content: "#Headline 
content is in markdown",class: "optional-classes"}}'
			),
			array(
				'menu_id' => '3',
				'menu_label' => 'Portfolio',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{0:{type: "image",column: 3,content: {src: "imagefile.png",description: "Some optional text"},class: "optional-classes"},1:{type: "text",column: 2,content: "#Headline 
content is in markdown",class: "optional-classes"}}'
			),
			array(
				'menu_id' => '4',
				'menu_label' => 'Contact',
				'status' => '1',
				'language' => 'en',
				'type' => '1',
				'title' => 'Entry',
				'content' => '{0:{type: "image",column: 3,content: {src: "imagefile.png",description: "Some optional text"},class: "optional-classes"},1:{type: "text",column: 2,content: "#Headline 
content is in markdown",class: "optional-classes"}}'
			),
		));
	}
    
}
