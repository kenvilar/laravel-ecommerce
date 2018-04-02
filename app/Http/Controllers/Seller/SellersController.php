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

    public function show($id)
    {
        $seller = Seller::query()->has('products')->findOrFail($id);

        return $this->showOne($seller);
    }
}
