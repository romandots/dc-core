<?php
/**
 * File: PersonFactory.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-17
 * Copyright (c) 2019
 */

declare(strict_types=1);

/* @var \Illuminate\Database\Eloquent\Factory  $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Person::class, static function (Faker $faker) {
    $username = $faker->word;
    return [
        'id' => \uuid(),
        'last_name' => $faker->name,
        'first_name' => $faker->name,
        'patronymic_name' => $faker->name,
        'birth_date' => \Carbon\Carbon::now(),
        'gender' => $faker->randomElement(\App\Models\Person::GENDER),
        'phone' => \normalize_phone_number($faker->unique()->phoneNumber),
        'email' => $faker->unique()->safeEmail,
        'picture' => $faker->imageUrl(),
        'picture_thumb' => $faker->imageUrl('200', '200'),
        'instagram_username' => $username,
        'telegram_username' => $username,
        'vk_uid' => $faker->numerify('#######'),
        'facebook_uid' => $faker->numerify('#######'),
        'note' => null,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now()
    ];
});
