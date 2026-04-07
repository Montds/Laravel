<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
class BuyerTransactionController extends ApiController
{

    public function index($id)
    {
        $buyer = Buyer::findOrFail($id);

        $transactions = $buyer->transactions;

        return $this->showElement($transactions);
    }

}
