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

Route::resource('buyers', 'Buyer\BuyersController', ['only' => ['index', 'show']]);

Route::resource('buyers.transactions', 'Buyer\BuyersTransactionsController', ['only' => ['index',]]);

Route::resource('buyers.products', 'Buyer\BuyersProductsController', ['only' => ['index',]]);

Route::resource('sellers', 'Seller\SellersController', ['only' => ['index', 'show']]);

Route::resource('users', 'User\UsersController', ['except' => ['create', 'edit']]);

Route::resource('categories', 'Category\CategoriesController', ['except' => ['create', 'edit']]);

Route::resource('products', 'Product\ProductsController', ['only' => ['index', 'show']]);

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
