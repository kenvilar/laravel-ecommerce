<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyersTransactionsController extends ApiController
{
    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;

        return $this->showAll($transactions);
    }
}
