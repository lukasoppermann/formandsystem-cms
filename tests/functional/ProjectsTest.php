<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;

class ProjectsTest extends TestCase
{

    /**
     * Open team page shows team members
     *
     * @return void
     */
    public function testSeeProjects()
    {
        $projects = 2;
        $user = $this->createUser($projects);

        $user->switchTeam($user->teams->first());

        $teams = $this->visit(route('teams.index'))->crawler->filter('.o-team');

        $this->assertCount($projects, $teams);
        $this->assertCount(1, $teams->filter('.is-active'));
    }
    /**
     * Switch to other project
     *
     * @return void
     */
    public function testSwitchProjects()
    {
        $projects = 2;
        $user = $this->createUser($projects);
        $user = $user->givePermissionTo('create teams');

        $user->switchTeam($user->teams->first());
        // get active project
        $teams = $this->visit(route('teams.index'))->crawler->filter('.o-team');
        $initallyActive = $teams->filter('.is-active');
        // click on switch button
        $this->click(trans('projects.activate'));
        $activeAfterClick = $this->visit(route('teams.index'))->crawler->filter('.o-team.is-active');

        $this->assertNotEquals($activeAfterClick, $initallyActive);

        $this->see(trans('projects.create'));
    }

    /**
     * Open projects page with no projects
     *
     * @return void
     * @group test
     */
    public function testNoProjects()
    {
        $projects = 0;
        $user = $this->createUser($projects);
        $teams = $this->visit(route('teams.index'))->crawler->filter('.o-team');

        $this->assertCount($projects, $teams);

        $this->see(trans('projects.noProjectsInfo'));
        $this->dontSee(trans('projects.create'));
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
