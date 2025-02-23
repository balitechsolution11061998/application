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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->string('kdJenisTransaksi', 2);
            $table->string('fgPengganti', 1);
            $table->string('nomorFaktur', 20);
            $table->date('tanggalFaktur');
            $table->string('npwpPenjual', 15);
            $table->string('namaPenjual', 255);
            $table->text('alamatPenjual');
            $table->string('npwpLawanTransaksi', 15);
            $table->string('namaLawanTransaksi', 255);
            $table->text('alamatLawanTransaksi');
            $table->decimal('jumlahDpp', 15, 2);
            $table->decimal('jumlahPpn', 15, 2);
            $table->decimal('jumlahPpnBm', 15, 2);
            $table->string('statusApproval', 255);
            $table->string('statusFaktur', 255);
            $table->string('referensi', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
