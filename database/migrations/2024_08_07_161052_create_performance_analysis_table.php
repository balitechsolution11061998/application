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
        // Create performance_analysis table
        Schema::create('performance_analysis', function (Blueprint $table) {
            $table->id();
            $table->integer('total_count');
            $table->integer('processed_count');
            $table->integer('success_count');
            $table->integer('fail_count');
            $table->text('errors')->nullable();
            $table->float('execution_time');
            $table->string('status');
            $table->timestamps();
        });

        // Create query_performance_logs table with foreign key
        Schema::create('query_performance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('function_name');
            $table->text('parameters')->nullable();
            $table->float('execution_time');
            $table->string('memory_usage');
            $table->float('ping')->nullable();
            $table->float('download_speed')->nullable();
            $table->float('upload_speed')->nullable();
            $table->string('ip_user')->nullable();
            $table->unsignedBigInteger('performance_analysis_id'); // Foreign key column
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('performance_analysis_id')->references('id')->on('performance_analysis')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_analysis');
    }
};
