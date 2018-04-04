<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyersCategoriesController extends ApiController
{
    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()->with('product.categories')->get()
            ->pluck('product.categories')->collapse()->unique('id')->values();

        return $this->showAll($categories);
    }
}
