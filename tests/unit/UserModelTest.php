<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserModelTest extends TestCase
{

    /**
     * Test get initals from user model
     *
     * @return void
     */
    public function testLastVerificationEmail()
    {
        $user = $this->createUser();

        activity('email verification')
            ->on($user)
            ->causedBy($user)
            ->log("User :causer.name resent email verification.");

        $date = $user->activity()->inLog('email verification')->first()->created_at;

        $this->assertEquals($date, App\Models\User::first()->lastVerificationEmail());
    }

    public function createUser()
    {
        return factory(App\Models\User::class)->create([
            'email' => $this->faker->email,
            'name' => 'Elisa Oppermann',
        ]);
    }
}
