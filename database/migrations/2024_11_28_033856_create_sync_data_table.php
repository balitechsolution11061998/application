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
        Schema::create('sync_data', function (Blueprint $table) {
            $table->id();
            $table->string('mode');
            $table->json('tungsura_chart')->nullable();
            $table->json('tungsura_administrasi')->nullable();
            $table->json('psu')->nullable();
            $table->boolean('status_suara')->default(false);
            $table->boolean('status_adm')->default(false);
            $table->json('images')->nullable();
            $table->timestamp('ts')->nullable();
            $table->unsignedBigInteger('province_id'); // Foreign key to provinces
            $table->unsignedBigInteger('kabupaten_id'); // Foreign key to kabupaten
            $table->unsignedBigInteger('kecamatan_id'); // Foreign key to kabupaten
            $table->unsignedBigInteger('kelurahan_id'); // Foreign key to kabupaten
            $table->unsignedBigInteger('tps_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_data');
    }
};
