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
        //
        Schema::table('temp_po', function (Blueprint $table) {
            // Primary key (assuming order_no is unique per PO)
            $table->integer('order_no')->unique();
            
            // Foreign key indexes
            $table->smallInteger('ship_to')->index();
            $table->integer('supplier')->index();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
