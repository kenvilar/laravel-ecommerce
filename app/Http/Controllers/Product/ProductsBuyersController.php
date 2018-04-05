<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;

class ProductsBuyersController extends ApiController
{
    public function index(Product $product)
    {
        $buyers = $product->transactions()->has('buyer')->with('buyer')->get()->pluck('buyer')
            ->unique()->values();

        return $this->showAll($buyers);
    }
}
