<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    public function store(Request $request, $productId, $buyerId)
    {

        $product = Product::findOrFail($productId);
        $buyer = User::findOrFail($buyerId);

        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('El comprador debe ser diferente al vendedor', 409);
        }

        if (!$buyer->esVerificado()) {
            return $this->errorResponse('El comprador debe ser un usuario verificado', 409);
        }

        if (!$product->seller->esVerificado()) {
            return $this->errorResponse('El vendedor debe ser un usuario verificado', 409);
        }

        if (!$product->estaDisponible()) {
            return $this->errorResponse('El producto para esta transacción no está disponible', 409);
        }

        if ($product->quantity < $data['quantity']) {
            return $this->errorResponse('El producto no tiene la cantidad disponible requerida para esta transacción', 409);
        }

        //esto es el equivalente de usar transactional de java pero en php
        //de manera resumida si ocurre un error revierte los cambios
        return DB::transaction(function () use ($data, $product, $buyer) {
            $product->quantity -= $data['quantity'];
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $data['quantity'],
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showElement($transaction, 201);
        });
    }
}
