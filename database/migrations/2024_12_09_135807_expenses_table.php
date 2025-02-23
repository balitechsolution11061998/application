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
        //
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // Kategori pengeluaran
            $table->decimal('amount', 10, 2); // Jumlah pengeluaran
            $table->date('expense_date'); // Tanggal pengeluaran
            $table->text('description')->nullable(); // Keterangan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('expenses');
    }
};
