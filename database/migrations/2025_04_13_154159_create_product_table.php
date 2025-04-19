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
        // Create products table (without expense-related types)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price'); // Harga default produk
            $table->string('image')->nullable();
            $table->string('sku')->unique();
            $table->string('upc')->nullable()->index();
            $table->text('description')->nullable();
            $table->json('options')->nullable();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['company_id', 'is_active']);
        });

        // Create paguyubans table (komunitas paguyuban)
        Schema::create('paguyubans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama paguyuban
            $table->text('description')->nullable(); // Deskripsi paguyuban
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create product_paguyuban table (relasi antara produk dan harga di paguyuban)
        Schema::create('product_paguyuban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete(); // Relasi ke produk
            $table->foreignId('paguyuban_id')->constrained('paguyubans')->cascadeOnDelete(); // Relasi ke paguyuban
            $table->integer('price'); // Harga khusus untuk paguyuban tertentu
            $table->timestamps();

            // Index untuk mempercepat pencarian
            $table->unique(['product_id', 'paguyuban_id']);
        });

        // Create expenses table (separate from products)
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('amount');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('category', ['operational', 'equipment', 'personnel', 'other']);
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence')->nullable(); // monthly, quarterly, etc.
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['company_id', 'is_active']);
            $table->index(['category', 'company_id']);
        });

        // Create bonuses table (connected to products)
        // Update the bonuses table schema
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('name');
            $table->enum('bonus_type', ['monthly', 'quarterly', 'annual', 'special']);
            $table->integer('amount'); // Add this line for the amount column
            $table->date('valid_from');
            $table->date('valid_to');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['product_id', 'is_active']);
            $table->index(['valid_from', 'valid_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });

        Schema::table('product_paguyuban', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['paguyuban_id']);
        });

        Schema::dropIfExists('bonuses');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('product_paguyuban');
        Schema::dropIfExists('paguyubans');
        Schema::dropIfExists('products');
    }
};
