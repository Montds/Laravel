<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionSellerController extends ApiController
{

    public function index(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $seller = $transaction->product->seller;
        return $this->showElement($seller);
    }

}
