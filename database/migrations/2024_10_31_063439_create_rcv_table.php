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
        Schema::create('rcvhead', function (Blueprint $table) {
            $table->id();
            $table->integer('receive_no')->index();
            $table->date('receive_date')->nullable()->index();
            $table->date('created_date')->nullable()->index();
            $table->string('receive_id')->nullable();
            $table->string('order_no')->nullable()->index();
            $table->string('ref_no')->nullable();
            $table->string('order_type')->nullable();
            $table->string('status_ind')->nullable();
            $table->date('approval_date')->nullable()->index();
            $table->string('approval_id')->nullable();
            $table->integer('store')->nullable()->index();
            $table->string('store_name')->nullable();
            $table->integer('supplier')->nullable()->index();
            $table->string('sup_name')->nullable();
            $table->string('comment_desc')->nullable();
            $table->string('status')->default('n');
            $table->integer('sub_total')->nullable();
            $table->integer('sub_total_vat_cost')->nullable();
            $table->double('average_service_level');
            $table->timestamps();
        });

        Schema::create('temp_rcv', function (Blueprint $table) {
			$table->integer('receive_no');
			$table->date('receive_date');
			$table->date('created_date');
			$table->string('receive_id', 50);
			$table->string('order_no')->nullable();
			$table->integer('ref_no')->nullable();
			$table->string('order_type', 10)->nullable();
			$table->string('status_ind', 5)->nullable();
			$table->date('approval_date');
			$table->string('approval_id', 50)->nullable();
			$table->integer('store');
			$table->string('store_name', 20);
			$table->integer('sku');
			$table->string('sku_desc');
			$table->string('upc', 20)->nullable();
			$table->integer('qty_expected')->nullable();
			$table->integer('qty_received')->nullable();
			$table->integer('unit_cost')->nullable();
			$table->integer('unit_retail')->nullable();
			$table->float('vat_cost')->nullable();
			$table->integer('unit_cost_disc')->nullable();
			$table->integer('supplier');
			$table->string('sup_name');
			$table->string('comment_desc')->nullable();
            $table->timestamps();
        });
        Schema::create('rcvdetail', function (Blueprint $table) {
            $table->id();
            $table->integer('rcvhead_id')->index();
            $table->integer('receive_no')->index();
            $table->integer('store')->nullable()->index();
            $table->integer('sku')->nullable()->index();
            $table->string('upc')->nullable()->index();
            $table->string('sku_desc')->nullable()->index();
            $table->integer('qty_expected')->nullable();
            $table->integer('qty_received')->nullable();
            $table->integer('unit_cost')->nullable();
            $table->integer('unit_retail')->nullable();
            $table->integer('vat_cost')->nullable();
            $table->integer('unit_cost_disc')->nullable();
            $table->double('service_level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rcv');
    }
};
