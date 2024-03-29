<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(App\User::class, function (Faker $faker) {

    $firstname = $faker->firstName;
    $lastname = $faker->lastName;
    $username = $firstname.".".$lastname;    
    $email = $username.'@test.com';

    return [
        'firstname' => $firstname,
        'lastname'	=> $lastname,
        'username'	=> $firstname.".".$lastname,
        'email' => $email,
        'email_verified_at' => now(),
        //'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'password' => bcrypt("lyrics1234"),
        'status' => 1,
        'remember_token' => Str::random(10),
        'api_token' => Str::random(50)
    ];
});

