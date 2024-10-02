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
            $table->integer('order_no')->unsigned();
            $table->integer('supplier')->unsigned();
            $table->string('sup_name', 255);
            $table->integer('sku')->unsigned();
            $table->string('sku_desc', 255);
            $table->double('cost_po');
            $table->double('cost_supplier')->nullable();
            $table->timestamps(); // for 'created_at' and 'updated_at'

            // Optionally, you can add indexes
            $table->index('order_no');
            $table->index('supplier');
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
