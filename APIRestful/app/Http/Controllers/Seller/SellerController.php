<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends ApiController
{

    public function index()
    {
        $vendedores = Seller::has("products")->get();
        return $this->showAll($vendedores);
    }

    public function show(string $id)
    {
            $vendedor = Seller::has("products")->findOrFail($id);
            return $this->showElement($vendedor);
    }

}
