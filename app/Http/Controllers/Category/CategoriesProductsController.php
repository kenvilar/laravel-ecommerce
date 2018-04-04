<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesProductsController extends ApiController
{
    public function index(Category $category)
    {
        $products = $category->products;
        
        return $this->showAll($products);
    }
}
