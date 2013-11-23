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
				'status' => '1',
				'title' => 'Entry',
				'content' => '{0:{type: "image",column: 3,content: {src: "imagefile.png",description: "Some optional text"},class: "optional-classes"},1:{type: "text",column: 2,content: "#Headline 
content is in markdown",class: "optional-classes"}}'
			),
			array(
				'status' => '1',
				'title' => 'Entry 02',
				'content' => '{0:{type: "image",column: 3,content: {src: "imagefile.png",description: "Some optional text"},class: "optional-classes"},1:{type: "text",column: 2,content: "#Headline 
content is in markdown",class: "optional-classes"}}'
			),
			array(
				'status' => '1',
				'title' => 'Entry 02',
				'content' => '{0:{type: "image",column: 3,content: {src: "imagefile.png",description: "Some optional text"},class: "optional-classes"},1:{type: "text",column: 2,content: "#Headline 
content is in markdown",class: "optional-classes"}}'
			)
		));
	}
    
}
