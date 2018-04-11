<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyersCategoriesController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('scope:read-general')->only('index');
    }

    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()->with('product.categories')->get()
            ->pluck('product.categories')->collapse()->unique('id')->values();

        return $this->showAll($categories);
    }
}
