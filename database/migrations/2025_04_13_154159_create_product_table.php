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
            $table->string('image')->nullable();
            $table->string('sku')->unique();
            $table->string('upc')->nullable()->index(); // Combined index with nullable
            $table->text('description')->nullable();
            $table->json('options')->nullable();
            $table->enum('type', ['product', 'bonus', 'distribution', 'service', 'dummy'])->default('product');
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Optimized indexes
            $table->index(['company_id', 'is_active']); // Composite index for active products by company
            $table->index(['type', 'company_id']); // For filtering by product type per company
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('products');
    }
};