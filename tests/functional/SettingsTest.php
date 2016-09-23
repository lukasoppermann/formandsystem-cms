<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;

class SettingsTest extends TestCase
{

    /**
     * Open Settings page
     *
     * @return void
     */
    public function testSeeSettings()
    {
        $user = $this->createUser(1);

        $this->visit(route('dashboard.index'));
        $this->seePageIs('/dashboard');

        $this->click(trans('menu.settings'));
        $this->seePageIs(route('teams.settings'));
        $this->see(trans('settings.site.title'));
    }


    protected function createUser($project_count = 0)
    {
        $password = $this->faker->password;

        $user = factory(App\Models\User::class)->create([
            'email' => $this->faker->email,
            'password' => Hash::make($password),
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
        $this->type($password, 'password');
        $this->press('signin');

        return $user;
    }
}
