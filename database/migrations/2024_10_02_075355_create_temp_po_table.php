<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('temp_po', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->string('ship_to')->nullable();
            $table->string('supplier');
            $table->string('terms')->nullable();
            $table->string('status_ind')->nullable();
            $table->date('written_date')->nullable();
            $table->date('not_before_date')->nullable();
            $table->date('not_after_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->unsignedBigInteger('approval_id')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->unsignedBigInteger('canceled_id')->nullable();
            $table->decimal('cancelled_amt', 15, 2)->nullable();
            $table->decimal('total_cost', 15, 2)->nullable();
            $table->decimal('total_retail', 15, 2)->nullable();
            $table->decimal('outstand_cost', 15, 2)->nullable();
            $table->decimal('total_discount', 15, 2)->nullable();
            $table->text('comment_desc')->nullable();
            $table->string('buyer')->nullable();
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
        });
    }

    public function down()
    {
        Schema::dropIfExists('temp_po');
    }
};
