<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerProductController extends ApiController
{

    public function index($id)
    {
        $seller = Seller::findOrFail($id);

        $products = $seller->products;

        return $this->showElement($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $datosValidados = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);


        $datosValidados['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        $datosValidados['image'] = 'img_producto1.png';
        $datosValidados['seller_id'] = $seller->id;

        $product = Product::create($datosValidados);

        return $this->showElement($product, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sellerId, $productId)
    {
        $seller = Seller::findOrFail($sellerId);
        $product = Product::findOrFail($productId);

        $datosValidados = $request->validate([
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::PRODUCTO_DISPONIBLE . ',' . Product::PRODUCTO_NO_DISPONIBLE,
            'image' => 'string',
            'name' => 'string',
            'description' => 'string',
        ]);

        if ($seller->id != $product->seller_id)
        {
            return $this->errorResponse('El vendedor  no es el vendedor real del producto', 422);
        }

        // fill() solo toma los Datos que coincidem con ely $fillable del modelo
        $product->fill($datosValidados);

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->estaDisponible() && $product->categories()->count() == 0) {
                return $this->errorResponse('Un producto activo debe tener al menos una categoría',
                    409);
            }
        }

        if ($product->isClean()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $product->save();

        return $this->showElement($product);
    }

    /**
     * Remove the specified resource from storage.

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sellerId, $productId)
    {
        $seller = Seller::findOrFail($sellerId);
        $product = Product::findOrFail($productId);

        if ($seller->id != $product->seller_id)
        {
            return $this->errorResponse('El vendedor especificado no es el vendedor real del producto', 422);
        }

        $product->delete();

        return $this->showOne($product);
    }
}
