<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerProductController extends ApiController
{

    public function index($id)
    {
        // Buscamos al comprador o fallamos (404)
        $buyer = Buyer::findOrFail($id);


        $products = $buyer
                   ->transactions()->with('product')->get()
                  ->pluck('product')->unique('id')->values();

       return $this->showElement($products);
    }

}
