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
        Schema::create('item_supplier', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier')->index();
            $table->string('sup_name')->nullable();
            $table->integer('sku')->index();
            $table->string('sku_desc')->nullable();
            $table->string('upc')->nullable();
            $table->double('unit_cost')->nullable();
            $table->string('create_id')->nullable();
            $table->string('create_date')->nullable();
            $table->string('last_update_id')->nullable();
            $table->string('last_update_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_supplier');
    }
};
