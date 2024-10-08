<?php

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
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('api_id')->nullable();
            $table->text('name');
            $table->string('image')->nullable();
            $table->string('country')->nullable();
            $table->string('brand')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->text('tags')->nullable();
            $table->text('ingredients')->nullable();
            $table->string('serving_size_unit')->nullable();
            $table->float('serving_size')->default(0);
            $table->float('calories')->default(0);
            $table->float('fat')->default(0);
            $table->float('carbohydrates')->default(0);
            $table->float('protein')->default(0);
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
};
