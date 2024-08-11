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
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ket', 30);
            $table->string('color', 6);
            $table->timestamps();
        });

        Schema::create('pengumuman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('opsi', 32);
            $table->text('isi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('kehadiran');
    }
};
