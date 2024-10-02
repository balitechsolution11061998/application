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
            $table->id();
            $table->string('order_no');
            $table->string('supplier');
            $table->string('sku');
            $table->string('sup_name');
            $table->decimal('cost_po', 15, 2);
            $table->decimal('cost_supplier', 15, 2)->nullable();
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
