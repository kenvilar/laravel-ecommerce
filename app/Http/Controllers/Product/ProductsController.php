<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;

class ProductsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
    }

    public function index()
    {
        $products = Product::all();

        return $this->showAll($products);
    }

    public function show(Product $product)
    {
        return $this->showOne($product);
    }
}
