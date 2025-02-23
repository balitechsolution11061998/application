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
        Schema::create('tungsuras', function (Blueprint $table) {
            $table->id();
            $table->json('chart')->nullable();
            $table->integer('suara_sah')->nullable();
            $table->integer('suara_total')->nullable();
            $table->integer('pemilih_dpt_j')->nullable();
            $table->integer('pemilih_dpt_l')->nullable();
            $table->integer('pemilih_dpt_p')->nullable();
            $table->integer('pengguna_dpt_j')->nullable();
            $table->integer('pengguna_dpt_l')->nullable();
            $table->integer('pengguna_dpt_p')->nullable();
            $table->integer('suara_tidak_sah')->nullable();
            $table->text('images')->nullable(); // Untuk menyimpan URL gambar
            $table->timestamp('timestamp')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tansura');
    }
};
