
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
         // Check if ordhead1 already exists
         if (Schema::hasTable('ordhead1')) {
            Schema::dropIfExists('ordhead1');

        }
        // Rename the existing table to ordhead1
        Schema::rename('ordhead', 'ordhead1');

        // Create the new ordhead table with modified structure
        Schema::create('ordhead', function (Blueprint $table) {
            $table->bigInteger('ordid')->primary(); // Primary key with custom format
            $table->integer('order_no')->unique(); // Unique order numbers
            $table->integer('ship_to')->index(); // Removed unique constraint
            $table->integer('supplier')->index(); // Removed unique constraint
            $table->integer('terms')->nullable();
            $table->string('status_ind')->nullable();
            $table->date('written_date')->nullable();
            $table->date('not_before_date')->nullable();
            $table->date('not_after_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('approval_id')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->string('canceled_id')->nullable();
            $table->integer('cancelled_amt')->nullable();
            $table->double('total_cost')->nullable()->index();
            $table->double('total_retail')->nullable()->index();
            $table->integer('outstand_cost')->nullable();
            $table->double('total_discount')->nullable()->index();
            $table->string('comment_desc')->nullable();
            $table->integer('buyer')->nullable();
            $table->string('status')->nullable();
            $table->text('reason')->nullable();
            $table->date('estimated_delivery_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamps();
        });

        // Migrate data from ordhead1 to ordhead with duplicate checking
        $existingOrderNos = DB::table('ordhead')->pluck('order_no')->toArray();
        
        DB::table('ordhead1')->orderBy('id')->chunk(200, function ($records) use ($existingOrderNos) {
            $recordsToInsert = [];
            
            foreach ($records as $record) {
                // Skip if order_no already exists
                if (in_array($record->order_no, $existingOrderNos)) {
                    continue;
                }
                
                // Generate ordid in format: yearmonthdayhourorder_no
                $writtenDate = $record->written_date ? Carbon::parse($record->written_date) : now();
                $ordid = (int) $writtenDate->format('YmdH') . $record->order_no;
                
                $recordsToInsert[] = [
                    'ordid' => $ordid,
                    'order_no' => $record->order_no,
                    'ship_to' => $record->ship_to,
                    'supplier' => $record->supplier,
                    'terms' => $record->terms,
                    'status_ind' => $record->status_ind,
                    'written_date' => $record->written_date,
                    'not_before_date' => $record->not_before_date,
                    'not_after_date' => $record->not_after_date,
                    'approval_date' => $record->approval_date,
                    'approval_id' => $record->approval_id,
                    'cancelled_date' => $record->cancelled_date,
                    'canceled_id' => $record->canceled_id,
                    'cancelled_amt' => $record->cancelled_amt,
                    'total_cost' => $record->total_cost,
                    'total_retail' => $record->total_retail,
                    'outstand_cost' => $record->outstand_cost,
                    'total_discount' => $record->total_discount,
                    'comment_desc' => $record->comment_desc,
                    'buyer' => $record->buyer,
                    'status' => $record->status,
                    'reason' => $record->reason,
                    'estimated_delivery_date' => $record->estimated_delivery_date,
                    'delivery_date' => $record->delivery_date,
                    'created_at' => $record->created_at,
                    'updated_at' => $record->updated_at,
                ];
                
                // Track the new order_no
                $existingOrderNos[] = $record->order_no;
            }
            
            if (!empty($recordsToInsert)) {
                DB::table('ordhead')->insert($recordsToInsert);
            }
        });
    }

    public function down()
    {
        // First, backup any data from ordhead back to ordhead1
        if (Schema::hasTable('ordhead1')) {
            DB::statement('
                INSERT INTO ordhead1 (
                    id, order_no, ship_to, supplier, terms, status_ind, 
                    written_date, not_before_date, not_after_date, approval_date, 
                    approval_id, cancelled_date, canceled_id, cancelled_amt, 
                    total_cost, total_retail, outstand_cost, total_discount, 
                    comment_desc, buyer, status, reason, estimated_delivery_date, 
                    delivery_date, created_at, updated_at
                )
                SELECT 
                    SUBSTRING(ordid, -LENGTH(order_no)) as id, 
                    order_no, ship_to, supplier, terms, status_ind, 
                    written_date, not_before_date, not_after_date, approval_date, 
                    approval_id, cancelled_date, canceled_id, cancelled_amt, 
                    total_cost, total_retail, outstand_cost, total_discount, 
                    comment_desc, buyer, status, reason, estimated_delivery_date, 
                    delivery_date, created_at, updated_at
                FROM ordhead
                ON DUPLICATE KEY UPDATE 
                    ordhead1.ship_to = VALUES(ship_to),
                    ordhead1.supplier = VALUES(supplier),
                    ordhead1.terms = VALUES(terms)
            ');
        }

        // Reverse the changes
        Schema::dropIfExists('ordhead');
        Schema::rename('ordhead1', 'ordhead');
    }
};