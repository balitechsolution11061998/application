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
        Schema::create('query_performance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('function_name');
            $table->string('parameters')->nullable();
            $table->float('execution_time');
            $table->integer('memory_usage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('query_performance_logs');
    }
};
