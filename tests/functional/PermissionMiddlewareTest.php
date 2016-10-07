<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;

class PermissionMiddlewareTest extends TestCase
{

    /**
     * Open team page shows team members
     *
     * @return void
     */
     public function testRedirectWithNotAuth(){

    }

    protected function createUser($project_count = 0)
    {
        $user = factory(App\Models\User::class)->create([
            'email' => $this->faker->email,
            'name' => $this->faker->name,
        ]);

        Permission::create(['name' => 'create teams']);

        if($project_count > 0){
            factory(App\Models\Team::class, $project_count)->create([
                'name' => $this->faker->name,
            ])->each(function($team) use ($user){
                $user->attachTeam($team);
            });
        }

        $this->visit('/login');
        $this->type($user->email, 'email');
        $this->type('secret', 'password'); // secret is the default password of user factory
        $this->press('signin');

        return $user;
    }
}
