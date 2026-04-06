<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends User
{

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
