<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellersController extends ApiController
{

    public function index()
    {
        $sellers = Seller::query()->has('products')->get();

        return $this->showAll($sellers);
    }

    public function show(Seller $seller)
    {
        //The original code of this method is
        //$seller = Seller::query()->has('products')->findOrFail($id);
        //meaning it has dependency method of has('products')
        //So you need to create a App\Scopes\SellerScope and put it on the Seller Model with boot method
        //to use and solve the laravel implicit model binding that has dependencies
        return $this->showOne($seller);
    }
}
