<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;

class ProductController extends ApiController
{
    public function index()
    {
        $products = Product::all();
        return $this->showElement($products);
    }


    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return $this->showElement($product);
    }

}
