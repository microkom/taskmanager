<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(User::class, function (Faker $faker) {
    
    return [
        'name' => $faker->name,
        /* 'employee_id' => App\Employee::, */
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$fVUc2cSubCmXvYxcSgGpQOb.l4MhHHU79e4Xllg792GRTjlQt0IOy', // password
        'remember_token' => Str::random(10),
    ];
});
