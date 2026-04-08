<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategoryTransactionController extends ApiController
{

    public function index($id)
    {
        // Buscamos la categoría manualmente por el ID recibido
        $category = Category::findOrFail($id);

        $transactions = $category->products()
            ->whereHas('transactions')//devolvera solo los productos que tengan transacciones
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->showElement($transactions);
    }

}
