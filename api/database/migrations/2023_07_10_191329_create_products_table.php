<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->string('name');
            $table->string('brand');
            $table->string('image_url')->nullable();
            $table->integer('serving_size');
            $table->integer('energy');
            $table->float('protein');
            $table->float('total_fat');
            $table->float('saturated_fat');
            $table->float('carbohydrates');
            $table->float('sugars');
            $table->float('sodium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
