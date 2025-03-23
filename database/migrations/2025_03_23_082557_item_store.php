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
        //
        Schema::create('item_store', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama bahan, misalnya "Bawang Merah"
            $table->integer('stock'); // Jumlah stok bahan
            $table->string('unit'); // Satuan bahan, misalnya "kg", "gram", "pcs"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('item_store');
    }
};
