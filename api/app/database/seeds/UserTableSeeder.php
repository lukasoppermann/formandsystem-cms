<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();
		
		DB::statement("ALTER TABLE `users` AUTO_INCREMENT = 1;");
		
		DB::table('users')->insert(array(
			array(
				'id' => '1',
				'email' => 'oppermann.lukas@gmail.com',
				'password' => Hash::make('lukas'),
			),
			array(
				'id' => '2',
				'email' => 'lukas@vea.re',
				'password' => Hash::make('lukas'),
			),
		));
	}
    
}
