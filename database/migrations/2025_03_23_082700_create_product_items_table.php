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
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity'); // Jumlah bahan yang dibutuhkan
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('item_store')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus foreign key constraint terlebih dahulu
        Schema::table('product_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['item_id']);
        });

        // Hapus tabel product_items
        Schema::dropIfExists('product_items');
    }
};
