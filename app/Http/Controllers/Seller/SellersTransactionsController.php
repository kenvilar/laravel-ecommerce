<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellersTransactionsController extends ApiController
{
    public function index(Seller $seller)
    {
        $transactions = $seller->products()->has('transactions')->with('transactions')->get()
            ->pluck('transactions')->collapse()->unique('id')->values();

        return $this->showAll($transactions);
    }
}
