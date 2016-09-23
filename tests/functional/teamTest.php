<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
{
    /**
     * Open team page shows team members
     *
     * @return void
     */
    public function testSeeTeam()
    {
        $this->visit(route('teams.members.show', 1));
    }
}
