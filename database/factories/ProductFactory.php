<?php

use Faker\Generator as Faker;
use App\Product;
use App\User;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'seller_id' => User::all()->random()->id,
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1, 10),
        'status' => $faker->randomElement([Product::AVAILABLE, Product::UNAVAILABLE]),
        'image' => $faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
    ];
});
