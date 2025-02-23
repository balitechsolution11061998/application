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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade'); // ID Anggota
            $table->string('jenis_usaha'); // Jenis Usaha
            $table->string('jaminan'); // Jaminan
            $table->decimal('amount', 10, 2); // Jumlah Pinjaman
            $table->date('loan_date'); // Tanggal Pinjaman
            $table->date('due_date'); // Tanggal Jatuh Tempo
            $table->integer('tenor'); // Tenor dalam bulan
            $table->decimal('interest_rate', 5, 2); // Suku Bunga
            $table->enum('status', ['active', 'paid', 'overdue'])->default('active'); // Status Pinjaman
            $table->string('no_identitas'); // No Identitas
            $table->string('no_pinjaman_ke')->nullable(); // No Pinjaman Ke
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
