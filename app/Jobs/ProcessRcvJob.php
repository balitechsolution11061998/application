<?php

namespace App\Jobs;

use App\Events\RcvProcessingComplete;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessRcvJob implements ShouldQueue
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
        // Filter out duplicate receive_no values
        $this->data = collect($data)->unique('receive_no')->values()->toArray();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $progressData = [
            'total_count' => count($this->data),
            'processed_count' => 0,
            'success_count' => 0,
            'fail_count' => 0,
            'errors' => []
        ];
        Cache::put('sync_progress_receiving', $progressData);

        $chunkSize = 10;
        $delayInMicroseconds = 100000;

        try {
            $chunks = array_chunk($this->data, $chunkSize);

            foreach ($chunks as $chunkIndex => $chunk) {
                Log::info("Processing chunk {$chunkIndex}");

                foreach ($chunk as $index => $data) {
                    try {
                        Log::info("Processing record: " . ($data['receive_no'] ?? 'unknown'));

                        DB::beginTransaction();

                        $rcvHeadData = [
                            "receive_no" => $data['receive_no'] ?? 'unknown',
                            "receive_date" => $data['receive_date'] ?? null,
                            "created_date" => $data['created_date'] ?? null,
                            "receive_id" => $data['receive_id'] ?? null,
                            "order_no" => $data['order_no'] ?? null,
                            "ref_no" => $data['ref_no'] ?? null,
                            "order_type" => $data['order_type'] ?? null,
                            "status_ind" => $data['status_ind'] ?? null,
                            "approval_date" => $data['approval_date'] ?? null,
                            "approval_id" => $data['approval_id'] ?? null,
                            "store" => $data['store'] ?? null,
                            "store_name" => $data['store_name'] ?? null,
                            "supplier" => $data['supplier'] ?? null,
                            "sup_name" => $data['sup_name'] ?? null,
                            "comment_desc" => $data['comment_desc'] ?? null,
                        ];

                        // Log data to be inserted or updated
                        Log::info("rcvHeadData: ", $rcvHeadData);

                        $uniqueAttributes = ["receive_no" => $data['receive_no'] ?? 'unknown'];
                        $existingRecord = DB::table('rcvhead')->where($uniqueAttributes)->first();

                        if ($existingRecord) {
                            DB::table('rcvhead')->where('id', $existingRecord->id)->update($rcvHeadData);
                            $rcvHeadId = $existingRecord->id;
                        } else {
                            $rcvHeadId = DB::table('rcvhead')->insertGetId(array_merge($uniqueAttributes, $rcvHeadData));
                        }

                        foreach ($data['rcv_detail'] as $detail) {
                            $rcvSkuData = [
                                "rcvhead_id" => $rcvHeadId,
                                "receive_no" => $data['receive_no'] ?? 'unknown',
                                "sku" => $detail['sku'] ?? 'unknown',
                                "sku_desc" => $detail['sku_desc'] ?? null,
                                "upc" => $detail['upc'] ?? null,
                                "qty_expected" => $detail['qty_expected'] ?? 0,
                                "qty_received" => $detail['qty_received'] ?? 0,
                                "unit_cost" => $detail['unit_cost'] ?? 0,
                                "unit_retail" => $detail['unit_retail'] ?? 0,
                                "vat_cost" => $detail['vat_cost'] ?? 0,
                                "unit_cost_disc" => $detail['unit_cost_disc'] ?? 0,
                                "service_level" => ($detail['qty_received'] / $detail['qty_expected']) * 100,
                            ];

                            // Log data for SKU details
                            Log::info("rcvSkuData: ", $rcvSkuData);

                            DB::table('rcvdetail')->updateOrInsert(
                                [
                                    "receive_no" => $data['receive_no'] ?? 'unknown',
                                    "sku" => $detail['sku'] ?? 'unknown',
                                    "upc" => $detail['upc'] ?? null
                                ],
                                $rcvSkuData
                            );
                        }

                        DB::commit();
                        Log::info("Successfully processed record: " . ($data['receive_no'] ?? 'unknown'));

                        $progressData['success_count']++;
                    } catch (Exception $e) {
                        DB::rollBack();
                        Log::error('Error processing record: ' . ($data['receive_no'] ?? 'unknown') . ' - ' . $e->getMessage());

                        $progressData['fail_count']++;
                        $progressData['errors'][] = [
                            'receive_no' => $data['receive_no'] ?? 'unknown',
                            'message' => $e->getMessage()
                        ];
                    }

                    $progressData['processed_count']++;
                    Cache::put('sync_progress_receiving', $progressData);
                }

                usleep($delayInMicroseconds);
            }
        } catch (Exception $e) {
            Log::error('Global error: ' . $e->getMessage());
            $progressData['fail_count']++;
            $progressData['errors'][] = [
                'receive_no' => 'unknown',
                'message' => $e->getMessage()
            ];
            Cache::put('sync_progress_receiving', $progressData);
        }

        event(new RcvProcessingComplete($progressData['success_count'], $progressData['fail_count'], $progressData['total_count'], $progressData['errors']));
        Cache::forget('sync_progress_receiving');
    }

}
