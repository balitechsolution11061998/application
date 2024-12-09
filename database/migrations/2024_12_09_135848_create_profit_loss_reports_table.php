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
        Schema::create('profit_loss_reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date'); // Tanggal laporan
            $table->decimal('total_revenue', 10, 2)->default(0); // Total pendapatan
            $table->decimal('total_expense', 10, 2)->default(0); // Total pengeluaran
            $table->decimal('net_profit', 10, 2)->default(0); // Laba bersih
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_loss_reports');
    }
};
