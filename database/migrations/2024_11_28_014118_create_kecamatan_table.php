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
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // Unique identifier for the kecamatan
            $table->string('nama'); // Name of the kecamatan
            $table->integer('tingkat'); // Level of the kecamatan
            $table->unsignedBigInteger('province_id'); // Foreign key to provinces
            $table->unsignedBigInteger('kabupaten_id'); // Foreign key to kabupaten
            $table->timestamps();

            // Foreign key constraints
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
    }
};
