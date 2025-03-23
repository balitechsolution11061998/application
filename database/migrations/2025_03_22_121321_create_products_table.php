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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->string('image');
            $table->string('sku')->unique()->index();
            $table->string('upc')->nullable()->index();
            $table->text('description')->nullable(); // Deskripsi produk
            $table->json('options')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product_items')) {
            Schema::table('product_items', function (Blueprint $table) {
                // Hapus foreign key jika ada
                $table->dropForeign(['product_id']);
            });
        }
        Schema::dropIfExists('products');
    }
};
