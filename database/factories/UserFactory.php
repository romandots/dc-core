<?php
/**
 * File: UserFactory.php
 * Author: Roman Dots <romandots@brainex.co>
 * Date: 2020-2-19
 * Copyright (c) 2020
 */

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'id' => \uuid(),
        'name' => $faker->name,
        'username' => $faker->unique()->name,
        'status' => User::STATUS_APPROVED,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'approved_at' => now(),
        'seen_at' => now(),
    ];
});
