<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoriesSellersController extends ApiController
{
    public function index(Category $category)
    {
        $seller = $category->products()->with('seller')->get()->pluck('seller')->unique()->values();

        return $this->showAll($seller);
    }
}
