<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryBuyerController extends ApiController
{
    public function index($id)
    {

        $category = Category::findOrFail($id);

        $buyers = $category->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')//por cuestion de larvel se tiene que primero colaptsar y despues accedr
            ->collapse()
            ->pluck('buyer')
            ->unique()
            ->values();

        return $this->showElement($buyers);
    }
}
