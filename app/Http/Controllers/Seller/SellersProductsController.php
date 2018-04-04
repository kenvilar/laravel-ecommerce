<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellersProductsController extends ApiController
{
    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->showAll($products);
    }

    //At first it is not a Seller role, it is a User that has not yet any product to sell   
    public function store(Request $request, User $seller)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ]);

        $data = $request->all();

        $data['status'] = Product::UNAVAILABLE;
        $data['image'] = "1.jpg";
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product);
    }

    public function update(Request $request, Seller $seller)
    {
        //
    }

    public function destroy(Seller $seller)
    {
        //
    }
}
