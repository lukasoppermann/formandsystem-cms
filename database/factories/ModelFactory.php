<?php

/*
|
| Run php artisan test-factory-helper:generate
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Models\Team::class, function (Faker\Generator $faker) {
    return [
        'owner_id' =>  $faker->randomNumber() ,
        'name' =>  $faker->name ,
    ];
});
