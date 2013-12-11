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
		
		DB::table('fs_navigation')->insert(array(
			array(
				'id' => '1',
				'parent_id' => '0'
			),
			array(
				'id' => '2',
				'parent_id' => '1'
			),
			array(
				'id' => '3',
				'parent_id' => '0'
			),
			array(
				'id' => '4',
				'parent_id' => '0'
			)
		));
	}
    
}
