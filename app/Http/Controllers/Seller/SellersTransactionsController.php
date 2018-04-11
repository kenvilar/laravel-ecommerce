<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellersTransactionsController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('scope:read-general')->only('index');
    }

    public function index(Seller $seller)
    {
        $transactions = $seller->products()->has('transactions')->with('transactions')->get()
            ->pluck('transactions')->collapse()->unique('id')->values();

        return $this->showAll($transactions);
    }
}
