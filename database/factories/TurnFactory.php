<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Turn;
use App\Employee;
use App\Task;
use Faker\Generator as Faker;


$factory->define(Turn::class, function (Faker $faker) {
    return [
        'employee_id' => Employee::all()->random()->id,
        'task_id' => Task::all()->random()->id,
        'turn' => $faker->numberBetween($min = 1, $max = 4), // 8567
        'date_time' => $faker->dateTimeThisMonth($max = 'now', $timezone = null)       // DateTime('2011-10-23 13:46:23', 'Antarctica/Vostok')
    ];
});
