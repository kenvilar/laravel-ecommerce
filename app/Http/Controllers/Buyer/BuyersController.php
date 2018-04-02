<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyersController extends ApiController
{

    public function index()
    {
        $buyers = Buyer::query()->has('transactions')->get();

        return $this->showAll($buyers);
    }

    public function show($id)
    {
        $buyer = Buyer::query()->has('transactions')->findOrFail($id);

        return $this->showOne($buyer);
    }
}
