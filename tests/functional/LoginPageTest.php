<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginPageTest extends \TestCase
{
    /**
     * @var FakerGenerator
     */
    protected $faker;

    /**
     * Setup faker
     */
    public function setUp()
    {
        parent::setUp();
        $this->faker = \Faker\Factory::create();
    }
    /**
     * My test implementation
     */
    public function testSignup()
    {
        $this->visit('/login');
        $this->click('Sign up');
        $this->type($this->faker->name, 'name');
        $this->type($this->faker->email, 'email');
        $this->type('password', 'password');
        $this->type('password', 'password_confirmation');
        $this->press('signup');
        $this->visit('/');

    }
    /**
     * Can user see login page
     */
    public function testSeePage()
    {
        $this->visit('/')
             ->see('Sign in');
    }
    /**
     * Can user log in?
     */
    public function testLogin()
    {
        $password = $this->faker->password;

        $user = factory(App\Models\User::class)->create([
            'email' => $this->faker->email,
            'password' => Hash::make($password),
        ]);

        $this->visit('/login');
        $this->type($user->email, 'email');
        $this->type($password, 'password');
        $this->press('signin');
        $this->seePageIs('/');
    }

    /**
     * Can user log in?
     */
    public function testSignupToSingin()
    {
        $this->visit('/register');
        $this->click('Sign in');
        $this->seePageIs('/login');
    }
}
