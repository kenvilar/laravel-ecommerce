<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyersController extends Controller
{

    public function index()
    {
        $buyers = Buyer::query()->has('transactions')->get();

        return response()->json(['data' => $buyers], 200);
    }

    public function show($id)
    {
        $buyers = Buyer::query()->has('transactions')->findOrFail($id);

        return response()->json(['data' => $buyers], 200);
    }
}
