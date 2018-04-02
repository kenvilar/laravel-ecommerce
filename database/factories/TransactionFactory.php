<?php

use Faker\Generator as Faker;
use App\Seller;
use App\Buyer;
use App\User;
use App\Transaction;

$factory->define(Transaction::class, function (Faker $faker) {
    $seller = Seller::query()->has('products')->get()->random();
    $buyer = User::all()->except($seller->id)->random();

    return [
        'quantity' => $faker->numberBetween(1, 100),
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id,
    ];
});
