<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; // 2. Usar el Trait aquí dentro
    //esos campos son,los unicos que se van a recibir
    protected $fillable=
        [
            "name",
            "description"
        ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
