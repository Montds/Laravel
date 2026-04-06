<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{

    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }


    public function show(string $id)
    {
        //se obtiene
        $product = Product::findOrFail($id);

        //se muestra
        return $this->showOne($product);
    }


}
