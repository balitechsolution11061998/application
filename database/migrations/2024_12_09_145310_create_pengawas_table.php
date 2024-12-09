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
        Schema::create('pengawas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengawas'); // Nama Pengawas
            $table->string('no_identitas')->unique(); // No Identitas
            $table->string('jabatan'); // Jabatan Pengawas
            $table->string('wilayah'); // Wilayah Kerja
            $table->string('telepon'); // Nomor Telepon
            $table->date('tanggal_masuk'); // Tanggal Masuk Kerja
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawas');
    }
};
