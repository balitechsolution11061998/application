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
        Schema::create('purchase_requisition_detail', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_requisition_detail_name');
            $table->unsignedBigInteger('purchase_requisition_id');
            $table->string('kebutuhan');
            $table->string('keterangan_kebutuhan');
            $table->integer('qty');
            $table->integer('hargaPerPcs');
            $table->string('hargaPerPcsRp');
            $table->integer('hargaTotal');
            $table->string('hargaTotalRp');
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_detail');
    }
};
