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
        Schema::create('system_usages', function (Blueprint $table) {
            $table->id();
            $table->decimal('memory_usage_mb', 8, 2); // Store memory usage in MB
            $table->integer('load_time_ms'); // Load time in milliseconds
            $table->timestamp('accessed_at'); // Timestamp of access
            $table->string('function');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_usages');
    }
};
