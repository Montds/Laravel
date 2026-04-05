<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * El modelo que este factory representa.
     */
    protected $model = Product::class;

    /**
     * Define el estado por defecto del modelo.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->paragraph(1),
            'quantity' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement([
                Product::PRODUCTO_DISPONIBLE,
                Product::PRODUCTO_NO_DISPONIBLE
            ]),
            // Tus imágenes personalizadas
            'image' => fake()->randomElement([
                'img_producto1.png',
                'img_producto2.png',
                'img_producto3.png'
            ]),

            // Relación con un vendedor aleatorio
            'seller_id' => User::all()->random()->id,
        ];
    }
}
