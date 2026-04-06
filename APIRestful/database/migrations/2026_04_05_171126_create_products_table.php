<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('quantity')->unsigned();
            $table->string('status')->default(Product::PRODUCTO_NO_DISPONIBLE);
            $table->string('image');

            // CORRECCIÓN AQUÍ:
            $table->foreignId('seller_id')
                ->constrained('users')
                ->onDelete('cascade'); // Si borras al User, borra sus Products

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
