<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserPresenterTest extends TestCase
{
    /**
     * Test get initals from user model
     *
     * @return void
     */
    public function testGetInitals()
    {
        factory(App\Models\User::class)->create([
            'email' => $this->faker->email,
            'password' => Hash::make($this->faker->word),
            'name' => 'Elisa Oppermann',
        ]);

        $this->assertEquals('EO', App\Models\User::first()->initials);
    }

    /**
     * Test get initals from user model
     *
     * @return void
     */
    public function testGetInitalsMoreNames()
    {
        factory(App\Models\User::class)->create([
            'email' => $this->faker->email,
            'password' => Hash::make($this->faker->word),
            'name' => 'Elisa Alexandra Oppermann',
        ]);

        $this->assertEquals('EO', App\Models\User::first()->initials);
    }

}
