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
         // Creating the 'orang_tua' table
         Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable()->index();
            $table->string('nama');
            $table->date('join_date')->nullable();
            $table->integer('region')->nullable();
            $table->text('alamat')->nullable();
            $table->text('about_us')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('pekerjaan')->nullable();
            $table->enum('hubungan', ['ayah', 'ibu', 'wali'])->default('wali');
            $table->timestamps();
            $table->softDeletes(); // Adding soft deletes
        });

        // Creating the 'siswas' table
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable()->index();
            $table->string('nis')->unique();
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('alamat')->nullable();
            $table->date('join_date')->nullable();
            $table->integer('region')->nullable();
            $table->text('about_us')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable()->unique();
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('ortu_id')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif', 'alumni'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Adding soft deletes

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
