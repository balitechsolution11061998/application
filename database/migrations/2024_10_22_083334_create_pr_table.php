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
            $table->string('no_pr');
            $table->integer('region_id');
            $table->integer('department_id');
            $table->string('nama_department');
            $table->string('nama_pembuat');
            $table->string('supplier_id')->nullable();
            $table->string('nama_supplier')->nullable();
            $table->date('tanggalpr');
            $table->dateTime('tanggal_update_step_pr');
            $table->string('kondisiBarang');
            $table->text('keteranganKondisiBarang');
            $table->string('pembayaran');
            $table->enum('status', ['progress', 'end', 'reject', 'buat po', 'approved']);
            $table->text('steps')->nullable();
            $table->text('nama_pr')->nullable();
            $table->integer('departement_pemesan');
            $table->integer('pengajuan_id')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_requisition_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_requisition_id');
            $table->string('purchase_requisition_detail_name', 255);
            $table->string('kebutuhan', 255);
            $table->string('keterangan_kebutuhan', 255)->nullable();
            $table->integer('qty');
            $table->integer('hargaPerPcs');
            $table->string('hargaPerPcsRp', 255)->nullable();
            $table->integer('hargaTotal');
            $table->string('hargaTotalRp', 255)->nullable();
            $table->string('satuan', 255);
            $table->timestamps();
        });
        Schema::create('purchase_requisition_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_requisition_id');
            $table->string('link_file')->nullable();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pr');
    }
};
