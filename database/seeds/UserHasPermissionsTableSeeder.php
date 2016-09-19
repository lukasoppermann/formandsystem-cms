<?php

use Illuminate\Database\Seeder;

class UserHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_has_permissions')->delete();
        
        \DB::table('user_has_permissions')->insert(array (
            0 => 
            array (
                'user_id' => 1,
                'permission_id' => 1,
            ),
        ));
        
        
    }
}
