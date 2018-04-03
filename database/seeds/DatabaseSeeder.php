<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use App\Seller;
use App\Buyer;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        User::query()->truncate();
        Seller::query()->truncate();
        Buyer::query()->truncate();
        Category::query()->truncate();
        Product::query()->truncate();
        Transaction::query()->truncate();
        DB::table('category_product')->truncate();

        $usersQuantity = 1000;
        $categoriesQuantity = 30;
        $sellersQuantity = 10;
        $buyersQuantity = 5;
        $productsQuantity = 1000;
        $transactionsQuantity = 1000;

        factory(User::class, $usersQuantity)->create();
        factory(Seller::class, $sellersQuantity)->create();
        factory(Buyer::class, $buyersQuantity)->create();
        factory(Category::class, $categoriesQuantity)->create();
        factory(Product::class, $productsQuantity)->create()->each(function ($product) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');

            //Attach the category to the product
            $product->categories()->attach($categories);
        });
        factory(Transaction::class, $transactionsQuantity)->create();
    }
}
