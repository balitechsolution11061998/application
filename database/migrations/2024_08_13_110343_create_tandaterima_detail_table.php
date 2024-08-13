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
        Schema::create('tandaterima_detail', function (Blueprint $table) {
            $table->unsignedInteger('id', true); // Explicitly set unsignedInteger with auto-increment
            $table->unsignedInteger('tthead_id');
            $table->string('no_tt', 34)->nullable();
            $table->string('no_antrean', 191);
            $table->string('receive_no', 191)->nullable();
            $table->unsignedInteger('store')->nullable();
            $table->date('receive_date')->nullable();
            $table->unsignedInteger('total_receive')->nullable();
            $table->string('invoice', 191)->nullable();
            $table->unsignedInteger('jumlah')->nullable();
            $table->string('faktur_pajak', 191)->nullable();
            $table->string('kategori_tt', 191)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('tthead_id')->references('id')->on('tandaterima_head')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tandaterima_detail');
    }
};
