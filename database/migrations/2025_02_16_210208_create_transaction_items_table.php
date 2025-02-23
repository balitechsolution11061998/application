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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_detail_id')->constrained('transaction_details')->onDelete('cascade');
            $table->string('nama', 255);
            $table->decimal('hargaSatuan', 15, 2);
            $table->integer('jumlahBarang');
            $table->decimal('hargaTotal', 15, 2);
            $table->decimal('diskon', 15, 2);
            $table->decimal('dpp', 15, 2);
            $table->decimal('ppn', 15, 2);
            $table->decimal('tarifPpnbm', 15, 2);
            $table->decimal('ppnbm', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
