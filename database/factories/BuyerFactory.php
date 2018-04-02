<?php

use Faker\Generator as Faker;

$factory->define(App\Buyer::class, function (Faker $faker) {
    $seller = \App\Seller::all()->random();
    $buyer = \App\User::all()->except($seller->id)->random();

    return [
        'id' => $buyer->id,
    ];
});
