<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Buyers
 */
Route::resource('buyers', 'Buyer\BuyersController', ['only' => ['index', 'show']]);

Route::resource('buyers.transactions', 'Buyer\BuyersTransactionsController', ['only' => ['index',]]);

Route::resource('buyers.products', 'Buyer\BuyersProductsController', ['only' => ['index',]]);

Route::resource('buyers.sellers', 'Buyer\BuyersSellersController', ['only' => ['index',]]);

Route::resource('buyers.categories', 'Buyer\BuyersCategoriesController', ['only' => ['index',]]);

/**
 * Sellers
 */
Route::resource('sellers', 'Seller\SellersController', ['only' => ['index', 'show']]);

Route::resource('sellers.transactions', 'Seller\SellersTransactionsController', ['only' => ['index',]]);

Route::resource('sellers.categories', 'Seller\SellersCategoriesController', ['only' => ['index',]]);

Route::resource('sellers.buyers', 'Seller\SellersBuyersController', ['only' => ['index',]]);

Route::resource('sellers.products', 'Seller\SellersProductsController', [
    'except' => ['create', 'show', 'edit',]
]);

/**
 * Users
 */
Route::resource('users', 'User\UsersController', ['except' => ['create', 'edit']]);

/**
 * Categories
 */
Route::resource('categories', 'Category\CategoriesController', ['except' => ['create', 'edit']]);

Route::resource('categories.products', 'Category\CategoriesProductsController', ['only' => ['index',]]);

Route::resource('categories.sellers', 'Category\CategoriesSellersController', ['only' => ['index',]]);

Route::resource('categories.buyers', 'Category\CategoriesBuyersController', ['only' => ['index',]]);

/**
 * Products
 */
Route::resource('products', 'Product\ProductsController', ['only' => ['index', 'show']]);

Route::resource('products.transactions', 'Product\ProductsTransactionsController', ['only' => ['index']]);

/**
 * Transactions
 */
Route::resource('transactions', 'Transaction\TransactionsController', ['only' => ['index', 'show']]);

Route::resource('transactions.categories', 'Transaction\TransactionsCategoriesController', [
    'only' => ['index',]
]);

Route::resource('transactions.sellers', 'Transaction\TransactionsSellersController', [
    'only' => ['index',]
]);

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
