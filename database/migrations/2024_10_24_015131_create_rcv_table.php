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
            $table->bigIncrements('id');
            $table->integer('receive_no');
            $table->date('receive_date');
            $table->date('created_date');
            $table->string('receive_id', 191)->nullable();
            $table->integer('order_no');
            $table->string('ref_no', 191)->nullable();
            $table->string('order_type', 191)->nullable();
            $table->string('status_ind', 191)->nullable();
            $table->date('approval_date')->nullable();
            $table->string('approval_id', 191)->nullable();
            $table->integer('store');
            $table->string('store_name', 191)->nullable();
            $table->integer('supplier');
            $table->string('sup_name', 191)->nullable();
            $table->string('comment_desc', 191)->nullable();
            $table->string('status', 191);
            $table->double('sub_total')->nullable();
            $table->double('sub_total_vat_cost')->nullable();
            $table->double('average_service_level')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('rcvdetail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rcvhead_id');
            $table->integer('receive_no');
            $table->integer('store')->nullable();
            $table->integer('sku')->nullable();
            $table->string('upc', 191)->nullable();
            $table->string('sku_desc', 191)->nullable();
            $table->integer('qty_expected')->nullable();
            $table->integer('qty_received')->nullable();
            $table->double('unit_cost')->nullable();
            $table->double('unit_retail')->nullable();
            $table->double('vat_cost')->nullable();
            $table->double('service_level');
            $table->double('unit_cost_disc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('receives', function (Blueprint $table) {
            $table->bigIncrements('receive_no');
            $table->date('receive_date');
            $table->date('created_date');
            $table->string('receive_id', 50)->collation('utf8mb4_unicode_ci');
            $table->integer('order_no')->nullable();
            $table->integer('ref_no')->nullable();
            $table->string('order_type', 10)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('status_ind', 5)->collation('utf8mb4_unicode_ci')->nullable();
            $table->date('approval_date');
            $table->string('approval_id', 50)->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('store');
            $table->string('store_name', 20)->collation('utf8mb4_unicode_ci');
            $table->integer('sku');
            $table->string('sku_desc', 191)->collation('utf8mb4_unicode_ci');
            $table->string('upc', 20)->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('qty_expected')->nullable();
            $table->integer('qty_received')->nullable();
            $table->double('unit_cost')->nullable();
            $table->double('unit_retail')->nullable();
            $table->double('vat_cost')->nullable();
            $table->double('unit_cost_disc')->nullable();
            $table->integer('supplier');
            $table->string('sup_name', 191)->collation('utf8mb4_unicode_ci');
            $table->string('comment_desc', 191)->collation('utf8mb4_unicode_ci ')->nullable();
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
