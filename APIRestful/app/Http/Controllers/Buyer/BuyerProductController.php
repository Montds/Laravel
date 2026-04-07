<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{

    public function index($id)
    {
        // Buscamos al comprador o fallamos (404)
        $buyer = Buyer::findOrFail($id);


        $products = $buyer->transactions()->with('product')->get()->pluck('product')->unique('id')->values();

       return $this->showElement($products);
    }

}
