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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_petugas'); // Nama Petugas
            $table->string('no_identitas')->unique(); // No Identitas
            $table->string('jabatan'); // Jabatan Pegawai
            $table->string('alamat'); // Alamat
            $table->string('telepon'); // Nomor Telepon
            $table->date('tanggal_masuk'); // Tanggal Masuk Kerja
            $table->decimal('gaji', 10, 2); // Gaji Bulanan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
