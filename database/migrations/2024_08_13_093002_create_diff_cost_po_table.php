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
        Schema::create('diff_cost_po', function (Blueprint $table) {
            $table->integer('order_no')->notNullable();
            $table->integer('supplier')->notNullable();
            $table->string('sup_name', 255)->collation('utf8mb4_unicode_ci')->notNullable();
            $table->integer('sku')->notNullable();
            $table->string('sku_desc', 255)->collation('utf8mb4_unicode_ci')->notNullable();
            $table->double('cost_po')->notNullable();
            $table->double('cost_supplier')->nullable();
            $table->timestamps(); // This will add 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diff_cost_po');
    }
};
