<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    public function up()
    {
        // Rename existing table to ordsku1
        if (Schema::hasTable('ordsku') && !Schema::hasTable('ordsku1')) {
            Schema::rename('ordsku', 'ordsku1');
        }

        // Create new ordsku table with modified structure
        Schema::create('ordsku', function (Blueprint $table) {
            $table->bigInteger('ordhead_id')->index();
            $table->integer('order_no')->index();
            $table->integer('sku')->index();
            $table->string('sku_desc')->nullable();
            $table->string('upc', 25)->nullable();
            $table->string('tag_code')->nullable();
            $table->double('unit_cost')->nullable();
            $table->double('unit_retail')->nullable();
            $table->double('vat_cost')->nullable();
            $table->double('luxury_cost')->nullable();
            $table->integer('qty_ordered')->nullable();
            $table->integer('qty_fulfilled')->nullable();
            $table->integer('qty_received')->nullable();
            $table->double('unit_discount')->nullable();
            $table->double('unit_permanent_discount')->nullable();
            $table->string('purchase_uom')->nullable();
            $table->integer('supp_pack_size')->nullable();
            $table->double('permanent_disc_pct')->nullable();
            $table->timestamps();
        });

        // Migrate data from ordsku1 to ordsku with proper ordhead_id mapping
        if (Schema::hasTable('ordsku1') && Schema::hasTable('ordhead')) {
            // Get all order_no to ordhead_id mappings first for better performance
            $orderMappings = DB::table('ordhead')
                ->pluck('ordid', 'order_no')
                ->toArray();
            
            DB::table('ordsku1')->orderBy('id')->chunk(200, function ($records) use ($orderMappings) {
                $data = [];
                
                foreach ($records as $record) {
                    // Get the correct ordhead_id from ordhead table based on order_no
                    $ordhead_id = $orderMappings[$record->order_no] ?? null;
                    
                    if ($ordhead_id) {
                        $data[] = [
                            'ordhead_id' => $ordhead_id,
                            'order_no' => $record->order_no,
                            'sku' => $record->sku,
                            'sku_desc' => $record->sku_desc,
                            'upc' => $record->upc,
                            'tag_code' => $record->tag_code,
                            'unit_cost' => $record->unit_cost,
                            'unit_retail' => $record->unit_retail,
                            'vat_cost' => $record->vat_cost,
                            'luxury_cost' => $record->luxury_cost,
                            'qty_ordered' => $record->qty_ordered,
                            'qty_fulfilled' => $record->qty_fulfilled,
                            'qty_received' => $record->qty_received,
                            'unit_discount' => $record->unit_discount,
                            'unit_permanent_discount' => $record->unit_permanent_discount,
                            'purchase_uom' => $record->purchase_uom,
                            'supp_pack_size' => $record->supp_pack_size,
                            'permanent_disc_pct' => $record->permanent_disc_pct,
                            'created_at' => $record->created_at,
                            'updated_at' => $record->updated_at,
                        ];
                    }
                }
                
                if (!empty($data)) {
                    DB::table('ordsku')->insert($data);
                }
            });
        }
    }

    public function down()
    {
        // Backup data to ordsku1 before dropping
        if (Schema::hasTable('ordsku') && !Schema::hasTable('ordsku1')) {
            Schema::rename('ordsku', 'ordsku1');
        }

        Schema::dropIfExists('ordsku');
        
        // Restore original table if exists
        if (Schema::hasTable('ordsku1')) {
            Schema::rename('ordsku1', 'ordsku');
        }
    }
};