<?php

namespace App\Models;

//cuando se usa extends como aqui se crea un rol no una tabla
class Seller extends User
{
    //el Seller tiene muchos productos
    public function products()
    {
        //quien este adentro de has many es el dueño de la relacion
        //cada producto tendra el id del seller
        return $this->hasMany(Product::class);
    }
}
