<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendedores = Seller::has("products")->get();
        return $this->showAll($vendedores);
    }

    public function show(string $id)
    {
        try
        {
            $vendedor = Buyer::has("products")->findOrFail($id);
            return $this->showOne($vendedor);
        }
        catch (\Exception $e)
        {
            return response()->json(["error" => $e->getMessage()], 200);
        }
    }



}
