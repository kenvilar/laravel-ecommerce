<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    public function update(Request $request, Seller $seller, Product $product)
    {
        $this->validate($request, [
            'quantity' => 'integer|min:1',
            'image' => 'image',
            'status' => 'in:' . Product::AVAILABLE . ',' . Product::UNAVAILABLE,
        ]);
        
        $this->checkSeller($seller, $product);
        
        $product->fill($request->only(['name', 'description', 'quantity']));

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->isAvailable() && $product->categories()->count() === 0) {
                return $this->errorResponse('An available product must have at least one category.', 409);
            }
        }

        if ($product->isClean()) {
            return $this->errorResponse('You need to specify a different value to update.', 422);
        }

        $product->save();
        
        return $this->showOne($product);
    }

    public function destroy(Seller $seller)
    {
        //
    }

    private function checkSeller(Seller $seller, Product $product) {
        if ($seller->id !== $product->seller_id) {
            throw new HttpException(422, 'The specified seller is not the actual seller of a product.');
        }
    }
}
