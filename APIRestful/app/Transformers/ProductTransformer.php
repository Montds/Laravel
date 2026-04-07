<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product) // He corregido $user por $product aquí
    {
        return [
            // He corregido todas las referencias internas de $user a $product
            'identificador'     => (int)$product->id,
            'titulo'            => (string)$product->name,
            'detalles'          => (string)$product->description,
            'disponibles'       => (string)$product->quantity,
            'estado'            => (string)$product->status,
            'imagen'            => url("img/{$product->image}"),
            'vendedor'          => (int)$product->seller_id,
            'fechaCreacion'     => (string)$product->created_at,
            'fechaActualizacion' => (string)$product->updated_at,
            // He mantenido la lógica de la imagen para la validación de eliminación
            'fechaEliminacion'   => isset($product->updated_at) ? (string)$product->deleted_at : null,
        ];
    }
}
