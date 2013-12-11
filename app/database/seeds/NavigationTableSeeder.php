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
			),
			array(
				'id' => '2',
			),
			array(
				'id' => '3',
			),
			array(
				'id' => '4',
			)
		));
	}
    
}
