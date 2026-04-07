<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{

    public function index($id)
    {

        $buyer = Buyer::findOrFail($id);

        $sellers = $buyer//compradores
            ->transactions()//transacciones de los compradores
            ->with('product.seller')->get() //transacciones con con productos que a laves tienen vendedores
             ->pluck('product.seller') //se obtienen los vendedores
             ->unique('id')//se eliminan repetidos
             ->values(); //se muestra como una lista ordenada

        return $this->showElement($sellers);
    }


}
