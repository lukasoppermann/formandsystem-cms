<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->truncate();
        DB::table('accounts')->insert([
            'id'        => (string)Uuid::uuid4(),
            'name' 		=> 'Client One Account',
            'created_at' => '0000-00-00',
            'updated_at' => '0000-00-00'
        ]);
    }
}
