<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ordsku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ordhead_id')->index();
            $table->integer('order_no')->index();
            $table->integer('sku')->index();
            $table->string('sku_desc')->nullable();
            $table->string('upc', 25)->index();
            $table->string('tag_code')->nullable();
            $table->double('unit_cost')->index();
            $table->double('unit_retail')->index();
            $table->double('vat_cost')->nullable();
            $table->double('luxury_cost')->nullable();
            $table->integer('qty_ordered')->nullable()->index();
            $table->integer('qty_fulfilled')->nullable()->index();
            $table->integer('qty_received')->nullable()->index();
            $table->double('unit_discount')->nullable()->index();
            $table->double('unit_permanent_discount')->nullable()->index();
            $table->string('purchase_uom')->nullable();
            $table->integer('supp_pack_size')->nullable()->index();
            $table->double('permanent_disc_pct')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordsku');
    }
};
