<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('account_user')->truncate();
        DB::table('users')->insert([
            'id'            => (string)Uuid::uuid4(),
            'firstname'     => 'Lukas',
            'lastname'      => 'Oppermann',
            'email'         => 'oppermann.lukas@gmail.com',
            'password'      => 'test',
            'created_at' => '0000-00-00',
            'updated_at' => '0000-00-00'
        ]);
        App\Models\User::where('firstname','Lukas')->first()->accounts()->attach(App\Models\Account::first()->id);
    }
}
