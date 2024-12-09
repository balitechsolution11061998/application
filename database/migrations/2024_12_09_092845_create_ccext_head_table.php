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
        Schema::create('ccext_head', function (Blueprint $table) {
            $table->id();
            $table->integer('cost_change_no');
            $table->string('cost_change_desc');
            $table->integer('reason');
            $table->integer('status');
            $table->date('active_date');
            $table->timestamp('create_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ccext_head');
    }
};
