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
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade'); // ID Anggota
            $table->decimal('amount', 10, 2); // Jumlah Simpanan
            $table->date('saving_date'); // Tanggal Simpanan
            $table->enum('type', ['mandatory', 'voluntary']); // Tipe Simpanan
            $table->string('description')->nullable(); // Keterangan (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
