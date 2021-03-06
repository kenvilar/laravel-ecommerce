<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellersController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('scope:read-general')->only('show');

        $this->middleware('can:view,seller')->only('show');
    }

    public function index()
    {
        $this->allowedAdminAction();

        $sellers = Seller::query()->has('products')->get();

        return $this->showAll($sellers);
    }

    public function show(Seller $seller)
    {
        //The original code of this method is
        //$seller = Seller::query()->has('products')->findOrFail($id);
        //meaning it has dependency method of has('products')
        //So you need to create a App\Scopes\SellerScope and put it on the Seller Model with boot method
        //to use and solve the laravel implicit model binding that has dependencies
        return $this->showOne($seller);
    }
}
