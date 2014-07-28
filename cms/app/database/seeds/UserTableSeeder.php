<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('fs_users')->delete();
		
		DB::statement("ALTER TABLE `fs_users` AUTO_INCREMENT = 1;");
		
		DB::table('fs_users')->insert(array(
			array(
				'id' => '1',
				'name' => 'Lukas Oppermann',
				'email' => 'oppermann.lukas@gmail.com',
				'password' => Hash::make('lukas'),
				'remember_token' => ''
			),
			array(
				'id' => '2',
				'name' => 'Elisa Heinig',
				'email' => 'lukas@vea.re',
				'password' => Hash::make('lukas'),
				'remember_token' => ''
			),
		));
	}
    
}
