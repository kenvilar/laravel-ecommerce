<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoriesTransactionsController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Category $category)
    {
        $transactions = $category->products()->has('transactions')->with('transactions')->get()
            ->pluck('transactions')->collapse();

        return $this->showAll($transactions);
    }
}
