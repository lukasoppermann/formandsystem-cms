<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $connection = app('config')->get('database.default');
        $db = app('config')->get('database.connections.'.$connection);
        
        if($db['driver'] === 'mysql'){
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        $this->call(AccountsTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        if($db['driver'] === 'mysql'){
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}
