<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;

class TransactionCategoryController extends ApiController
{
    public function index(string $id)
    {
        $transaction = Transaction::findOrFail($id );
        $categories = $transaction->product->categories;
        return $this->showElement($categories);
    }


}
