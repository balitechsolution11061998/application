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
        Schema::create('print_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->integer('printed_by'); // User who printed
            $table->timestamp('printed_at')->useCurrent(); // Timestamp of when it was printed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_histories');
    }
};
