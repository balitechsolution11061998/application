<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsertOrderData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function handle()
    {
        $ordheadData = [];
        $ordskuData = [];

        for ($i = $this->start; $i <= $this->end; $i++) {
            $ordheadId = DB::table('ordhead')->insertGetId([
                'order_no' => $i,
                'ship_to' => rand(1, 10),
                'supplier' => rand(1, 10),
                'terms' => 30,
                'status_ind' => 'Pending',
                'written_date' => Carbon::now(),
                'not_before_date' => Carbon::now()->addDays(5),
                'not_after_date' => Carbon::now()->addDays(30),
                'approval_date' => null,
                'release_date' => null,
                'approval_id' => null,
                'cancelled_date' => null,
                'canceled_id' => null,
                'cancelled_amt' => null,
                'total_cost' => rand(1000, 10000),
                'total_retail' => rand(1000, 10000),
                'outstand_cost' => rand(1000, 5000),
                'total_discount' => rand(100, 500),
                'comment_desc' => 'Order '.$i,
                'buyer' => rand(1, 10),
                'status' => 'Pending',
                'reason' => 'N/A',
                'estimated_delivery_date' => Carbon::now()->addDays(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $ordskuData[] = [
                'ordhead_id' => $ordheadId,
                'order_no' => $i,
                'sku' => rand(100000, 999999),
                'sku_desc' => 'SKU Description '.$i,
                'upc' => '0123456789'.rand(0, 9),
                'tag_code' => 'TAG'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'unit_cost' => rand(10, 100),
                'unit_retail' => rand(15, 120),
                'vat_cost' => rand(1, 20),
                'luxury_cost' => rand(0, 10),
                'qty_ordered' => rand(1, 100),
                'qty_fulfilled' => rand(0, 50),
                'qty_received' => rand(0, 50),
                'unit_discount' => rand(0, 10),
                'unit_permanent_discount' => rand(0, 5),
                'purchase_uom' => 'Box',
                'supp_pack_size' => rand(1, 10),
                'permanent_disc_pct' => rand(0, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('ordsku')->insert($ordskuData);
    }
}
