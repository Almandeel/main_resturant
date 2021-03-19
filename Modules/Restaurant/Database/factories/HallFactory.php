<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Modules\Restaurant\Models\Hall;
use Faker\Generator as Faker;

$factory->define(Hall::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'size' => random_int(10, 100),
        'manager_id' => User::inRandomOrder()->first()->id,
        'phone' => $faker->e164PhoneNumber,
    ];
});