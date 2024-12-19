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
        Schema::create('supplier_quantities', function (Blueprint $table) {
            $table->id();
            $table->string('order_no'); // Reference to the order number
            $table->string('supplier_code'); // Reference to the supplier
            $table->integer('available_quantity'); // Quantity that can be fulfilled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_quantities');
    }
};
