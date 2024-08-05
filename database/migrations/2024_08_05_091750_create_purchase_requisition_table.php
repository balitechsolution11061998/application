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
        Schema::create('purchase_requisition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_pr', 255);
            $table->integer('region_id');
            $table->integer('department_id');
            $table->string('nama_department', 255)->collation('utf8mb4_unicode_ci');
            $table->string('nama_pembuat', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('supplier_id', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('nama_supplier', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->date('tanggalpr');
            $table->dateTime('tanggal_update_step_pr');
            $table->string('kondisiBarang', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('keteranganKondisiBarang')->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('pembayaran', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->enum('status', ['progress', 'end', 'reject', 'buat po', 'approve'])->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('steps')->collation('utf8mb4_unicode_ci')->nullable();
            $table->text('nama_pr')->collation('utf8mb4_unicode_ci')->nullable();
            $table->integer('departement_pemesan');
            $table->integer('pengajuan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition');
    }
};
