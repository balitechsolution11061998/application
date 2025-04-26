<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('paguyuban_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paguyuban_id')
            ->constrained()
            ->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->decimal('price', 10, 2); // If you need to store price in pivot
            $table->timestamps();
            $table->softDeletes();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paguyuban_product');
    }
};
