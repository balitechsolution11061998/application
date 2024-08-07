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
        Schema::create('rcvdetail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rcvhead_id');
            $table->integer('receive_no');
            $table->integer('store')->nullable();
            $table->integer('sku')->nullable();
            $table->string('upc', 20)->nullable();
            $table->string('sku_desc', 191)->nullable();
            $table->integer('qty_expected')->nullable();
            $table->integer('qty_received')->nullable();
            $table->integer('unit_cost')->nullable();
            $table->integer('unit_retail')->nullable();
            $table->double('vat_cost', 8, 2)->nullable();
            $table->integer('service_level')->nullable();
            $table->integer('unit_cost_disc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rcvdetail');
    }
};
