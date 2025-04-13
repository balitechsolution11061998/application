<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('expense_category'); // e.g., 'operational', 'service', 'maintenance'
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence')->nullable(); // e.g., 'monthly', 'weekly'
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('product_id');
            $table->index('expense_category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};