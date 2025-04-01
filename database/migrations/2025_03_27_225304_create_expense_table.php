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
        // Check if table exists before creating
        if (!Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->decimal('amount', 10, 2);
                $table->date('date');
                $table->text('description')->nullable();
                $table->string('type'); // 'employee_bonus', 'maintenance', etc.
                $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
                $table->timestamps();
            });
        }

        // Create pivot tables only if they don't exist
        if (!Schema::hasTable('voucher_product')) {
            Schema::create('voucher_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('voucher_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->integer('quantity')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('voucher_expense')) {
            Schema::create('voucher_expense', function (Blueprint $table) {
                $table->id();
                $table->foreignId('voucher_id')->constrained()->onDelete('cascade');
                $table->foreignId('expense_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Add column if it doesn't exist
        if (Schema::hasTable('products') {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'is_water_game')) {
                    $table->boolean('is_water_game')->default(false);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop pivot tables
        Schema::dropIfExists('voucher_expense');
        Schema::dropIfExists('voucher_product');
        
        // Don't drop expenses table here as it might contain important data
        // Just remove the column we added
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'is_water_game')) {
                    $table->dropColumn('is_water_game');
                }
            });
        }
    }
};