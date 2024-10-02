<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ordsku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordhead_id');
            $table->string('order_no');
            $table->string('sku');
            $table->text('sku_desc')->nullable();
            $table->string('upc')->nullable();
            $table->string('tag_code')->nullable();
            $table->decimal('unit_cost', 15, 2);
            $table->decimal('unit_retail', 15, 2)->nullable();
            $table->decimal('vat_cost', 15, 2)->nullable();
            $table->decimal('luxury_cost', 15, 2)->nullable();
            $table->integer('qty_ordered')->nullable();
            $table->integer('qty_received')->nullable();
            $table->decimal('unit_discount', 10, 2)->nullable();
            $table->decimal('unit_permanent_discount', 10, 2)->nullable();
            $table->string('purchase_uom')->nullable();
            $table->integer('supp_pack_size')->nullable();
            $table->decimal('permanent_disc_pct', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('ordhead_id')->references('id')->on('ordhead')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordsku');
    }
};
