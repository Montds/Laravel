<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;


class CategorySellerController extends ApiController
{

    public function index($id)
    {
        $category = Category::findOrFail($id);

        $sellers = $category->products()
            ->with('seller')
            ->get()
            ->pluck('seller')
            ->unique()
            ->values();

        return $this->showElement($sellers);
    }

}
