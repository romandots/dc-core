<?php
/**
 * File: ClassroomFactory.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-31
 * Copyright (c) 2019
 */

declare(strict_types=1);

/* @var \Illuminate\Database\Eloquent\Factory  $factory */

use App\Models\Classroom;
use Faker\Generator as Faker;

$factory->define(Classroom::class, static function (Faker $faker) {
    return [
        'id' => \uuid(),
        'name' => $faker->randomLetter,
        'branch_id' => \factory(\App\Models\Branch::class),
        'color' => $faker->colorName,
        'capacity' => $faker->numberBetween(10, 25),
        'number' => $faker->randomNumber(),
    ];
});
