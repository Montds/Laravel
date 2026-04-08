<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerController extends ApiController
{
    public function index()
    {
        //devuelve los buyer o mas bien los usuarios que tengan transacaciones
        //aunque como solo los buyer tienen transacion en si devuelve a los buyers
        $compradores = Buyer::has("transactions")->get();
        return $this->showElement($compradores);
    }


    public function show(string $id)
    {
            $comprador = Buyer::has("transactions")->findOrFail($id);
            $this->showElement($comprador);
    }

}
