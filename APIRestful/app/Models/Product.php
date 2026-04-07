<?php

namespace App\Models;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $transformer = ProductTransformer::class;

    const string PRODUCTO_DISPONIBLE = 'disponible';
    const string PRODUCTO_NO_DISPONIBLE = 'no disponible';

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];
    protected $hidden = [
        'pivot'
    ];

    public function estaDisponible(){
        return $this->status == self::PRODUCTO_DISPONIBLE;
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class  );
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    //actualiza el estado del producto a no disponible cuando llega a cero en un evento
    protected static function booted(): void
    {
        static::updated(function (Product $product)
        {
            if ($product->quantity == 0 && $product->estaDisponible()) {
                $product->status = Product::PRODUCTO_NO_DISPONIBLE;
                $product->saveQuietly();
            }
        });
    }

}
