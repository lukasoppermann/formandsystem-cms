<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'create teams',
                'created_at' => '2016-09-18 14:55:34',
                'updated_at' => '2016-09-18 14:55:38',
            ),
        ));


    }
}
