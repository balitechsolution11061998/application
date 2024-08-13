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
        Schema::create('tandaterima_head', function (Blueprint $table) {
            $table->unsignedInteger('id', true); // Explicitly set unsignedInteger with auto-increment
            $table->string('no_tt', 34)->nullable();
            $table->string('no_antrean', 191);
            $table->unsignedInteger('supplier');
            $table->string('sup_name', 191)->nullable();
            $table->string('terms_desc', 191)->nullable();
            $table->date('tanggal')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->unsignedInteger('total')->nullable();
            $table->unsignedInteger('approval_id')->nullable();
            $table->string('status', 191)->default('n');
            $table->timestamps();
            $table->string('terms', 191)->nullable();
            $table->unsignedInteger('region_id');
            $table->text('alasan_reject')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tandaterima_head');
    }
};
