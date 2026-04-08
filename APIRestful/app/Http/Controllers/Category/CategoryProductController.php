<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategoryProductController extends ApiController
{

    public function index($id)
    {
        $category = Category::findOrFail($id);

        $products = $category->products;

        return $this->showElement($products);
    }

}
