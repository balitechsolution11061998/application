<?php

namespace App\Jobs;

use App\Events\OrderProcessingComplete;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Exception;

class ProcessOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Initialize cache with progress data
        $progressData = [
            'total_count' => count($this->data),
            'processed_count' => 0,
            'success_count' => 0,
            'fail_count' => 0,
            'errors' => []
        ];
        Cache::forget('sync_progress');
        Cache::put('sync_progress', $progressData);

        $totalPo = count($this->data);
        $chunkSize = 10; // Process 10 records per chunk
        $delayInMicroseconds = 100000; // Delay in microseconds (100000 µs = 0.1 seconds)

        try {
            $chunks = array_chunk($this->data, $chunkSize);

            foreach ($chunks as $chunkIndex => $chunk) {
                foreach ($chunk as $index => $data) {
                    try {
                        // Process the main order data
                        $dataOrder = [
                            "order_no" => $data['order_no'] ?? 'unknown',
                            "ship_to" => $data['ship_to'] ?? null,
                            "supplier" => $data['supplier'] ?? null,
                            "terms" => $data['terms'] ?? null,
                            "status_ind" => $data['status_ind'] ?? null,
                            "written_date" => $data['written_date'] ?? null,
                            "not_before_date" => $data['not_before_date'] ?? null,
                            "not_after_date" => $data['not_after_date'] ?? null,
                            "approval_date" => $data['approval_date'] ?? null,
                            "approval_id" => $data['approval_id'] ?? null,
                            "cancelled_date" => $data['cancelled_date'] ?? null,
                            "canceled_id" => $data['canceled_id'] ?? null,
                            "cancelled_amt" => $data['cancelled_amt'] ?? 0,
                            "total_cost" => $data['total_cost'] ?? 0,
                            "total_retail" => $data['total_retail'] ?? 0,
                            "outstand_cost" => $data['outstand_cost'] ?? 0,
                            "total_discount" => $data['total_discount'] ?? 0,
                            "comment_desc" => $data['comment_desc'] ?? null,
                            "buyer" => $data['buyer'] ?? null,
                            "status" => $data['status'] ?? "Progress",
                        ];

                        $uniqueAttributes = ["order_no" => $data['order_no'] ?? 'unknown'];
                        $existingRecord = DB::table('ordhead')->where($uniqueAttributes)->first();

                        if ($existingRecord) {
                            DB::table('ordhead')->where('id', $existingRecord->id)->update($dataOrder);
                            $ordheadId = $existingRecord->id;
                        } else {
                            $ordheadId = DB::table('ordhead')->insertGetId(array_merge($uniqueAttributes, $dataOrder));
                        }

                        // Process the order details
                        foreach ($data['ord_detail'] as $detail) {
                            $ordSkuData = [
                                "ordhead_id" => $ordheadId,
                                "order_no" => $data['order_no'] ?? 'unknown',
                                "sku" => $detail['sku'] ?? 'unknown',
                                "sku_desc" => $detail['sku_desc'] ?? null,
                                "upc" => $detail['upc'] ?? null,
                                "tag_code" => $detail['tag_code'] ?? null,
                                "unit_cost" => $detail['unit_cost'] ?? 0,
                                "unit_retail" => $detail['unit_retail'] ?? 0,
                                "vat_cost" => $detail['vat_cost'] ?? 0,
                                "luxury_cost" => $detail['luxury_cost'] ?? 0,
                                "qty_ordered" => $detail['qty_ordered'] ?? 0,
                                "qty_received" => $detail['qty_received'] ?? 0,
                                "unit_discount" => $detail['unit_discount'] ?? 0,
                                "unit_permanent_discount" => $detail['unit_permanent_discount'] ?? 0,
                                "purchase_uom" => $detail['purchase_uom'] ?? null,
                                "supp_pack_size" => $detail['supp_pack_size'] ?? null,
                                "permanent_disc_pct" => $detail['permanent_disc_pct'] ?? 0,
                            ];

                            DB::table('ordsku')->updateOrInsert(
                                [
                                    "order_no" => $data['order_no'] ?? 'unknown',
                                    "sku" => $detail['sku'] ?? 'unknown',
                                    "upc" => $detail['upc'] ?? null
                                ],
                                $ordSkuData
                            );
                        }

                        // Increment success count
                        $progressData['success_count']++;

                    } catch (Exception $e) {
                        // Increment fail count and record the error
                        $progressData['fail_count']++;
                        $progressData['errors'][] = [
                            'order_no' => $data['order_no'] ?? 'unknown',
                            'message' => $e->getMessage()
                        ];
                    }

                    // Update processed count and cache progress
                    $progressData['processed_count'] = ($chunkIndex * $chunkSize) + $index + 1;
                    Cache::put('sync_progress', $progressData);
                }

                // Introduce a delay between processing chunks
                usleep($delayInMicroseconds); // Delay for 0.1 seconds
            }
        } catch (Exception $e) {
            // Handle global exception
            $progressData['fail_count']++;
            $progressData['errors'][] = [
                'order_no' => 'unknown',
                'message' => $e->getMessage()
            ];
            Cache::put('sync_progress', $progressData);
        }

        // Clear progress cache once done
        Cache::forget('sync_progress');

        // Dispatch the event with final counts and errors
        event(new OrderProcessingComplete($progressData['success_count'], $progressData['fail_count'], $progressData['total_count'], $progressData['errors']));
    }

}
