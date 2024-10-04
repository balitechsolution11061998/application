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
            $table->integer('order_no')->nullable();
            $table->integer('supplier')->nullable();
            $table->string('sup_name')->nullable();
            $table->integer('sku')->nullable();
            $table->string('sku_desc')->nullable();
            $table->double('cost_po')->nullable();
            $table->double('cost_supplier')->nullable();
            $table->timestamps();

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
