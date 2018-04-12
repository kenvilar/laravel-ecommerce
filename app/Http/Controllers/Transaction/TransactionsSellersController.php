<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;

class TransactionsSellersController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('scope:read-general')->only('index');

        $this->middleware('can:view,transaction')->only('index');
    }

    public function index(Transaction $transaction)
    {
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }
}
