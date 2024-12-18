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
        Schema::create('order_confirmation_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_no'); // Assuming order_no is an integer
            $table->date('confirmation_date');
            $table->unsignedBigInteger('username');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_confirmation_histories');
    }
};
