<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Lukas Oppermann',
                'email' => 'oppermann.lukas@gmail.com',
                'password' => '$2y$10$cRLG9A6JzWjQrH5vZkBJYOwl.oSnXK7FnpXTtleZVThYjEmp3sDyi',
                'remember_token' => 'rFmlwMxoOGOlv9HKR6uYfWy8DpyG3CVBtl8iVRQHsExZJBLOldaNOa1cASSc',
                'created_at' => '2016-09-13 11:21:08',
                'updated_at' => '2016-09-13 12:03:27',
                'current_team_id' => 1,
                'verified' => 0,
                'verification_token' => '6ffc811e4a97bb42e20db76e0645ee7298370bce1747a782bf3043104540eedf',
            ),
        ));
        
        
    }
}
