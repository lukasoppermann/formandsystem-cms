<?php

class NavigationTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('fs_navigation')->delete();
		
		DB::statement("ALTER TABLE `fs_navigation` AUTO_INCREMENT = 1;");
		
		DB::table('fs_navigation')->insert(array(
			array(
				'id' => '1',
				'parent_id' => '0',
				'position' => 1,
				'article_id' => 8
			),
			array(
				'id' => '2',
				'parent_id' => '1',
				'position' => 1,
				'article_id' => 1
			),
			array(
				'id' => '3',
				'parent_id' => '0',
				'position' => 1,
				'article_id' => 2
			),
			array(
				'id' => '4',
				'parent_id' => '0',
				'position' => 1,
				'article_id' => 3
			),
			array(
				'id' => '5',
				'parent_id' => '0',
				'position' => 2,
				'article_id' => 4
			),
			array(
				'id' => '6',
				'parent_id' => '1',
				'position' => 2,
				'article_id' => 5
			),
			array(
				'id' => '7',
				'parent_id' => '0',
				'position' => 2,
				'article_id' => 6
			)
		));
	}
    
}
