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
        // Create the 'spp_fees' table first
        Schema::create('spp_fees', function (Blueprint $table) {
            $table->id();
            $table->integer('tingkat');
            $table->string('tahun_ajaran', 9);
            $table->decimal('jumlah', 10, 2);
            $table->timestamps();
        });

        // Create the 'classes' table after 'spp_fees'
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 20);
            $table->integer('tingkat');
            $table->string('wali_kelas', 50)->nullable();
            $table->string('tahun_ajaran', 9);
            $table->foreignId('spp_id')->constrained('spp_fees')->onDelete('cascade');
            $table->timestamps();
        });

        // Create the 'students' table after 'classes'
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 20)->unique();
            $table->string('nama', 50);
            $table->foreignId('kelas_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->text('alamat')->nullable();
            $table->string('telepon', 15)->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_masuk');
            $table->foreignId('user_id_ayah')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id_ibu')->nullable()->constrained('users')->onDelete('set null');
            $table->string('pekerjaan_ayah', 50)->nullable();
            $table->string('pekerjaan_ibu', 50)->nullable();
            $table->timestamps();
        });

        // Create the 'class_histories' table
        Schema::create('class_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('tahun_ajaran', 9);
            $table->date('tanggal_pindah')->nullable();
            $table->timestamps();
        });

        // Create the 'spp_payments' table
        Schema::create('spp_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('students')->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->enum('status', ['lunas', 'belum'])->default('belum');
            $table->date('tanggal_bayar')->nullable();
            $table->enum('metode_bayar', ['cash', 'transfer', 'e-wallet'])->nullable();
            $table->timestamps();
        });

        // Create the 'payment_details' table
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('spp_payments')->onDelete('cascade');
            $table->string('deskripsi', 255);
            $table->decimal('jumlah_detail', 10, 2);
            $table->timestamps();
        });

        // Create the 'payment_logs' table
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('spp_payments')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('tanggal_log')->useCurrent();
            $table->string('aktivitas', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
        Schema::dropIfExists('payment_details');
        Schema::dropIfExists('spp_payments');
        Schema::dropIfExists('class_histories');
        Schema::dropIfExists('students');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('spp_fees');
    }
};
