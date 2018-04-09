<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellersBuyersController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Seller $seller)
    {
        $buyers = $seller->products()->has('transactions')->with('transactions.buyer')->get()
            ->pluck('transactions')->collapse()->pluck('buyer')->unique('id')->values();

        return $this->showAll($buyers);
    }
}
