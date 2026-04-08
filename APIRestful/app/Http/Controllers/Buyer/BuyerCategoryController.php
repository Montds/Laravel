<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerCategoryController extends ApiController
{

    public function index($id)
    {

        $buyer = Buyer::findOrFail($id);

        $categories = $buyer->transactions()//transacciones
               ->with('product.categories')//transacciones con product y estos tienen categories
               ->get()
               ->pluck('product.categories')// se obtienen solo los categoires , pero estan en listas de variado elemento
               ->collapse()//se juntan todas las lista en una sola lista
                ->unique('id')//para que no se repitan
                ->values()
        ;
        return $this->showElement($categories);
    }

}
