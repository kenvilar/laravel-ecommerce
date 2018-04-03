<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Transaction;

class TransactionsController extends ApiController
{
    public function index()
    {
        $transactions = Transaction::all();

        return $this->showAll($transactions);
    }

    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }
}
