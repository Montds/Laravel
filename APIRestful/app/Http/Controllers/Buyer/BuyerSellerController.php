<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{


    /*
    public function index($id)
    {

        $buyer = Buyer::findOrFail($id);

        // 2. Obtenemos los vendedores procesando toda la cadena en una sola sentencia
        $sellers = $buyer->transactions// Accedemos a la relación de transacciones
       ->with('product.seller')->get()      // Cargamos de golpe productos y sus vendedores (Eager Loading)
        ->pluck('product')            // Extraemos los objetos 'product' de cada transacción
        ->pluck('seller')             // De esos productos, extraemos sus respectivos 'seller'
        ->unique('id')                // Eliminamos vendedores duplicados
        ->values();                   // Reindexamos el array para una respuesta JSON limpia

        // 3. Retornamos la respuesta filtrada
        return $this->showAll($sellers);
    }
    */

}
