<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesTransactionsController extends ApiController
{
    public function index(Category $category)
    {
        $transactions = $category->products()->whereHas('transactions')->with('transactions')->get()
            ->unique('id')->values();

        return $this->showAll($transactions);
    }
}
