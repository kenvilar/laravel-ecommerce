<?php

use Illuminate\Database\Seeder;
use App\Buyer;
use App\Category;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Buyer::truncate();
        Category::truncate();
        Product::truncate();
        Seller::truncate();
        Transaction::truncate();
        User::truncate();
    }
}
