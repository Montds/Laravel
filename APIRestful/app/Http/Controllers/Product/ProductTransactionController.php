<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductTransactionController extends ApiController
{

    public function index($id)
    {
        $product = Product::findOrFail($id);

        $transactions = $product->transactions;

        return $this->showElement($transactions);
    }


}
