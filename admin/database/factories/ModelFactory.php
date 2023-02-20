<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(ObeliskAdmin\User::class, function (Faker\Generator $faker) {
    $username = $faker->username;

    return [
        'username' => preg_replace("/[^a-zA-Z0-9]+/", "", $username),
        'fullname' => $faker->name,
        'password' => hash('sha256', $faker->password . $username),
        'level' => 'Agent',
        'manual_dial' => true,
        'active' => true
    ];
});
