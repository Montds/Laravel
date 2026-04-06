<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{

    public function index()
    {
        //devuelve los buyer o mas bien los usuarios que tengan transacaciones
        //aunque como solo los buyer tienen transacion en si devuelve a los buyers

        $compradores = Buyer::has("transactions")->get();
        return $this->showAll($compradores);
    }


    public function show(string $id)
    {

        try
        {
            $comprador = Buyer::has("transactions")->findOrFail($id);

            $this->showOne($comprador);
        }
        catch (\Exception $e)
        {
            return response()->json(["error" => $e->getMessage()], 200);
        }
    }

}
