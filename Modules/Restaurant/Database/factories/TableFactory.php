<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Restaurant\Models\{Hall, Table};

$factory->define(Table::class, function (Faker $faker) {
    return [
        'hall_id' => $faker->randomElement(array_merge(Hall::all()->modelKeys(), [null])),
        'status' => random_int(0, 1),
    ];
});
