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


        Schema::create('supplier', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('supp_code');
            $table->string('supp_name', 191);
            $table->integer('terms');
            $table->string('contact_name', 191);
            $table->string('contact_phone', 191);
            $table->string('contact_fax', 191);
            $table->string('email', 191);
            $table->string('address_1', 191);
            $table->string('address_2', 191);
            $table->string('city', 191);
            $table->string('post_code', 255);
            $table->char('tax_ind', 191);
            $table->string('tax_no', 191);
            $table->char('retur_ind', 191);
            $table->char('consig_ind', 191);
            $table->char('status', 191);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier');
    }
};
