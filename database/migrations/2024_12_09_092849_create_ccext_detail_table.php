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
        Schema::create('ccext_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('ccext_no');
            $table->integer('supplier');
            $table->string('sku');
            $table->decimal('unit_cost', 10, 2);
            $table->integer('old_unit_cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ccext_detail');
    }
};
