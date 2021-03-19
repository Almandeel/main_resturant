<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Restaurant\Models\{Menu, Waiter, Order};

$factory->define(Order::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->afterCreating(Order::class, static function (Order $order) {
});
