<?php

namespace Database\Factories;

use App\Models\Seller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        // 1. Buscamos un vendedor que tenga productos
        $vendedor = Seller::has('products')->get()->random();

        // 2. Buscamos un comprador que NO sea el mismo vendedor
        $comprador = User::all()->except($vendedor->id)->random();

        return [
            'quantity' => fake()->numberBetween(1, 3),
            'buyer_id' => $comprador->id,
            // 3. Elegimos un producto aleatorio de ese vendedor específico
            'product_id' => $vendedor->products->random()->id,
        ];
    }
}
