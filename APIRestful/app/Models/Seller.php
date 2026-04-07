<?php

namespace App\Models;

//cuando se usa extends como aqui se crea un rol no una tabla
use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends User
{
    public $transformer = SellerTransformer::class;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
