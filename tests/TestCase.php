<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * @var FakerGenerator
     */
    protected $faker;
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://cms.formandsystem.dev:8080';
    /**
     * Setup faker
     */
    public function setUp()
    {
        parent::setUp();
        $this->faker = \Faker\Factory::create();
    }
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        putenv('DB_DEFAULT=sqlite_testing');
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        Artisan::call('migrate:reset');
        Artisan::call('migrate');

        return $app;
    }

}
