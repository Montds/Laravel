<?php

namespace App\Transformers;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{

    public function transform(Seller $seller)
    {
        return [
            'identificador'      => (int)$seller->id,
            'nombre'             => (string)$seller->name,
            'correo'             => (string)$seller->email,
            'esVerificado'       => (int)$seller->verified,
            'fechaCreacion'      => (string)$seller->created_at,
            'fechaActualizacion' => (string)$seller->updated_at,
            'fechaEliminacion'   => isset($seller->updated_at) ? (string)$seller->deleted_at : null,
        ];
    }
}
