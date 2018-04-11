<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyersController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('scope:read-general')->only('index');

        $this->middleware('can:view,buyer')->only('show');
    }

    public function index()
    {
        $buyers = Buyer::query()->has('transactions')->get();

        return $this->showAll($buyers);
    }

    public function show(Buyer $buyer)
    {
        //The original code of this method is
        //$buyer = Buyer::query()->has('transactions')->findOrFail($id);
        //meaning it has dependency method of has('transactions')
        //So you need to create a App\Scopes\BuyerScope and put it on the Buyer Model with boot method
        //to use the laravel implicit model binding
        return $this->showOne($buyer);
    }
}
