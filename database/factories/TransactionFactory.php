<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'quantity' => $faker->numberBetween(1, 100),
        'buyer_id' => \App\User::all()->random()->id,
        'product_id' => \App\Product::all()->random()->id,
    ];
});
