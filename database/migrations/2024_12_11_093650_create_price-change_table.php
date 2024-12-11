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
        //
        Schema::create('pricelist_head', function (Blueprint $table) {
            $table->id();
            $table->string('pricelist_no')->index()->nullable();
            $table->string('pricelist_desc')->nullable();
            $table->date('active_date')->nullable();
            $table->integer('supplier_id')->index();
            $table->integer('role_last_app')->nullable();
            $table->integer('role_next_app')->nullable();
            $table->string('approval_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('pricelist_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('pricelist_head_id')->index();
            $table->bigInteger('barcode')->index();
            $table->string('item_desc')->nullable();
            $table->integer('old_cost')->index();
            $table->integer('new_cost')->index();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('pricelist_head');
        Schema::dropIfExists('pricelist_detail');
    }
};
