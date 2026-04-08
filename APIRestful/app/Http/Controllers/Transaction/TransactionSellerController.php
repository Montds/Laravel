<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;

class TransactionSellerController extends ApiController
{

    public function index(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $seller = $transaction->product->seller;
        return $this->showElement($seller);
    }

}
