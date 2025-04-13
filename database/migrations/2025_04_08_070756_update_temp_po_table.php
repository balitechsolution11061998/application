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
        Schema::table('temp_po', function (Blueprint $table) {
            // Check if columns exist before adding
            if (!Schema::hasColumn('temp_po', 'order_no')) {
                $table->integer('order_no');
            }
            
            if (!Schema::hasColumn('temp_po', 'ship_to')) {
                $table->smallInteger('ship_to');
            }
            
            if (!Schema::hasColumn('temp_po', 'supplier')) {
                $table->integer('supplier');
            }

            // Add composite unique index on all three fields
            $table->unique(['order_no', 'ship_to', 'supplier'], 'temp_po_order_ship_supplier_unique');
            
            // Add individual indexes for foreign key relationships
            $table->index('ship_to', 'temp_po_ship_to_index');
            $table->index('supplier', 'temp_po_supplier_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_po', function (Blueprint $table) {
            // Drop the composite unique index
            $table->dropUnique('temp_po_order_ship_supplier_unique');
            
            // Drop the individual indexes
            $table->dropIndex('temp_po_ship_to_index');
            $table->dropIndex('temp_po_supplier_index');
            
            // Note: We're not dropping the columns here since they might contain data
            // If you want to drop columns, uncomment these:
            // $table->dropColumn(['order_no', 'ship_to', 'supplier']);
        });
    }
};