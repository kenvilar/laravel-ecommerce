<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Seller::class, function (Faker $faker) {
    return [
        'id' => User::all()->random()->id,
    ];
});
