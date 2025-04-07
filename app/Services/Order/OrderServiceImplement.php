<?php

namespace App\Services\Order;

use App\Helpers\SystemUsageHelper;
use App\Jobs\SendMessagePo;
use App\Models\User;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Order\OrderRepository;
use App\Repositories\OrderSku\OrderSkuRepository;
use App\Repositories\OrdHead\OrdHeadRepository;
use App\Repositories\OrdSku\OrdSkuRepository;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderServiceImplement extends ServiceApi implements OrderService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected string $title = "";
     /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected OrdHeadRepository $mainRepository;
    protected OrdSkuRepository $ordSkuRepository;

    public function __construct(OrdHeadRepository $mainRepository, OrdSkuRepository $ordSkuRepository)
    {
        $this->mainRepository = $mainRepository;
        $this->ordSkuRepository = $ordSkuRepository;
    }

    // Define your custom methods :)
    public function store($orders)
    {
        // Record the start time and memory usage
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        foreach ($orders as $orderData) {
            try {
                // Create or update the main order record
                $ordHead = $this->mainRepository->updateOrCreate($orderData);
                // Log the creation or update of the main order
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($ordHead)
                    ->withProperties(['order_no' => $orderData['order_no']])
                    ->log('Created or updated order header');

                // Process `ord_detail` items in chunks for efficient handling
                collect($orderData['ord_detail'])->chunk(100)->each(function ($chunk) use ($ordHead) {
                    try {
                        foreach ($chunk as $item) {
                            $item['ordhead_id'] = $ordHead->id;
                            $this->ordSkuRepository->updateOrCreate($item);
                        }

                        Log::info('Processed a chunk of order details for order ID ' . $ordHead->id);
                    } catch (\Exception $e) {
                        Log::error('Failed to process chunk for order ID ' . $ordHead->id, ['error' => $e->getMessage()]);
                    }
                });

                // Retrieve supplier information
                $supplierNo = (string) $ordHead->supplier;

                $emailSuppliers = User::where('username', $supplierNo)->get();

                foreach ($emailSuppliers as $supplier) {

                    try {
                        // dd("masuk sini nggak>",$supplier);

                        // Prepare the data payload for the job
                        $dataOrder = [
                            'email' => $supplier->email,
                            'name' => $supplier->name,
                            'order_no' => $orderData['order_no'],
                            'total_amount' => $orderData['total_cost'],
                            'download_link' => env('APP_URL') . "/po/pdf?id=" . $orderData['order_no'],
                        ];

                        // Dispatch the email job
                        SendMessagePo::dispatch($dataOrder);

                        // Log the dispatch activity
                        activity()
                            ->withProperties(['email' => $supplier->email])
                            ->log('Dispatched email job for supplier ' . $supplier->email);
                    } catch (\Exception $e) {
                        activity()
                        ->withProperties([
                            'email' => $supplier->email,
                            'error_message' => $e->getMessage(),
                        ])
                        ->log('Failed to dispatch email job for supplier ' . $supplier->email);
                    }
                }



                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($ordHead)
                    ->withProperties(['order_no' => $orderData['order_no']])
                    ->log('Successfully processed order');
            } catch (\Exception $e) {
                Log::error('Error processing order', ['error' => $e->getMessage()]);
                activity()
                    ->causedBy(auth()->user())
                    ->withProperties(['order_data' => $orderData])
                    ->log('Failed to process order');
            }
        }

        // Log system usage after processing all orders
        SystemUsageHelper::logUsage($startTime, $startMemory,now(),'orderData');

        return response()->json([
            'message' => 'Data PO stored successfully',
            'title' => 'PO stored success',
        ]);
    }

}
