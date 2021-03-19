<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Modules\Restaurant\Models\Menu;

use Faker\Generator as Faker;

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
