<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;

class TransactionController extends ApiController
{

    public function index()
    {
        $transactions = Transaction::all();
        return $this->showElement($transactions);
    }


    public function show(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        return $this->showElement($transaction);
    }

}
