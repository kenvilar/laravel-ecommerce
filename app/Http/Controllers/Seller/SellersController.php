<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellersController extends ApiController
{

    public function index()
    {
        $sellers = Seller::query()->has('products')->get();

        return response()->json(['data' => $sellers], 200);
    }

    public function show($id)
    {
        $seller = Seller::query()->has('products')->findOrFail($id);

        return response()->json(['data' => $seller], 200);
    }
}
