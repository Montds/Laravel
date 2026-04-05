<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // Limpiar tablas (Truncate)
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        // Definir cantidades
        $cantidadUsuarios = 200;
        $cantidadCategorias = 30;
        $cantidadProductos = 1000;
        $cantidadTransacciones = 1000;

        // 1. Crear Usuarios
        User::factory()->count($cantidadUsuarios)->create();

        // 2. Crear Categorías
        Category::factory()->count($cantidadCategorias)->create();

        // 3. Crear Productos y asignarles categorías aleatorias (Muchos a Muchos)
        Product::factory()->count($cantidadProductos)->create()->each(
            function ($producto) {
                // Selecciona entre 1 y 5 IDs de categorías al azar
                $categorias = Category::all()->random(mt_rand(1, 5))->pluck('id');

                // Los asocia en la tabla pivote
                $producto->categories()->attach($categorias);
            }
        );

        // 4. Crear Transacciones
        Transaction::factory()->count($cantidadTransacciones)->create();

        // Volver a activar llaves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
