<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Employee;
use Faker\Generator as Faker;
/* use Faker\Provider\es_ES\Person as Esp;
 */


$factory->define(Employee::class, function (Faker $faker ) {
    $faker->addProvider(new \Faker\Provider\es_ES\Person($faker));
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'dni' => $faker->dni,
        /* 'email' => $faker->email(), */
        'scale_number' => $faker->numberBetween($min = 1, $max = 9000), // 8567
        'position_id' => $faker->numberBetween($min = 1, $max = 4), // 8567
        'cip_code' => $faker->numerify('LN_###') // 'Hello 609'
    ];
});

