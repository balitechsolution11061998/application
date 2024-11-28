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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode');
            $table->integer('tingkat');
            $table->timestamps();
        });
        Schema::create('kabupatens', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->string('nama');
            $table->string('kode');
            $table->integer('tingkat');
            $table->integer('province_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabupaten');
    }
};
