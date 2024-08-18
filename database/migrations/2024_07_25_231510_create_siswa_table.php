<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama lengkap orang tua
            $table->string('alamat'); // Alamat orang tua
            $table->string('telepon')->nullable(); // Nomor telepon orang tua (opsional)
            $table->string('email')->nullable()->unique(); // Email orang tua (opsional, harus unik jika ada)
            $table->string('pekerjaan')->nullable(); // Pekerjaan orang tua (opsional)
            $table->enum('hubungan', ['ayah', 'ibu', 'wali'])->default('wali'); // Hubungan dengan siswa (opsional)
            $table->timestamps();
        });

        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique(); // Nomor Induk Siswa, harus unik
            $table->string('nama'); // Nama lengkap siswa
            $table->enum('jk', ['L', 'P']); // Jenis kelamin siswa, 'L' untuk laki-laki, 'P' untuk perempuan
            $table->date('tanggal_lahir'); // Tanggal lahir siswa
            $table->string('alamat'); // Alamat rumah siswa
            $table->string('telepon')->nullable(); // Nomor telepon siswa (opsional)
            $table->string('email')->nullable()->unique(); // Email siswa (opsional, harus unik jika ada)
            $table->unsignedBigInteger('kelas_id'); // ID kelas siswa
            $table->unsignedBigInteger('ortu_id')->nullable(); // ID orang tua/wali (opsional)
            $table->date('tanggal_masuk')->nullable(); // Tanggal masuk sekolah (opsional)
            $table->date('tanggal_lulus')->nullable(); // Tanggal lulus sekolah (opsional)
            $table->enum('status', ['aktif', 'tidak_aktif', 'alumni'])->default('aktif'); // Status siswa
            $table->text('catatan')->nullable(); // Catatan tambahan mengenai siswa (opsional)
            $table->string('golongan_darah')->nullable(); // Golongan darah siswa (opsional)
            $table->string('tempat_lahir')->nullable(); // Tempat lahir siswa (opsional)
            $table->string('foto')->nullable(); // Foto siswa (opsional, URL atau path)
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('ortu_id')->references('id')->on('orang_tua')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orang_tua');
        Schema::dropIfExists('siswa');
    }
}
