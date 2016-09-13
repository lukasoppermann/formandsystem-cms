<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use MailThief\Testing\InteractsWithMail;

class LoginPageTest extends \TestCase
{
    use InteractsWithMail;
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
     * Can user see login page
     */
    public function testSeePage()
    {
        $this->visit('/')
             ->see('Sign in');
    }
    /**
     * My test implementation
     */
    public function testSignup()
    {
        $email = $this->faker->email;
        $this->visit('/login');
        $this->click('Sign up');
        $this->type($this->faker->name, 'name');
        $this->type($email, 'email');
        $this->type('password', 'password');
        $this->type('password', 'password_confirmation');
        $this->press('signup');
        $this->seePageIs(route('dashboard.index'));

        $this->seeMessageFor($email);
        $this->seeMessageWithSubject(trans('laravel-user-verification::user-verification.verification_email_subject'));
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
        $this->seePageIs(route('dashboard.index'));

        $this->see(trans('notifications.email_verification_needed'));
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

    /**
     * Reset
     */
    public function testResetPassword()
    {
        $password = $this->faker->password;
        $user = factory(App\Models\User::class)->create([
            'email' => $this->faker->email,
            'password' => $password,
            'name' => $this->faker->name,
        ]);

        $this->visit('/login');
        $this->click('Forgot Your Password?');
        $this->type($user->email, 'email');
        $this->press('get_reset_email');
        $this->seePageIs('/password/reset');

        $this->seeMessageFor($user->email);
        $this->seeMessageWithSubject('Reset Password');
        // // Make sure the email was sent from the correct address
        // $this->seeMessageFrom(config('mail.from.address'));

        $this->visit($this->lastMessage()->data['actionUrl']);
        $this->type($user->email, 'email');
        $this->type($password, 'password');
        $this->type($password, 'password_confirmation');
        $this->press('reset_password');
        $this->seePageIs(route('dashboard.index'));
    }
}
