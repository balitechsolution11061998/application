<?php

namespace App\Services\Order;

use App\Models\User;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Order\OrderRepository;
use App\Repositories\OrderSku\OrderSkuRepository;
use App\Repositories\OrdHead\OrdHeadRepository;
use App\Repositories\OrdSku\OrdSkuRepository;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Log;

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
        foreach ($orders as $orderData) {
            try {
                // Create or update the main order record
                $ordHead = $this->mainRepository->updateOrCreate($orderData);

                // Log the creation or update of the main order
                Activity::create([
                    'log_name' => 'order_log',
                    'description' => 'Created or updated order header',
                    'subject_type' => 'Order',
                    'subject_id' => $ordHead->id,
                    'properties' => ['order_no' => $orderData['order_no']]
                ]);

                // Process `ord_detail` items in chunks for efficient handling
                collect($orderData['ord_detail'])->chunk(100)->each(function ($chunk) use ($ordHead) {
                    try {
                        // Update or create each `ord_detail` item and associate with the main order
                        foreach ($chunk as $item) {
                            $item['ordhead_id'] = $ordHead->id;
                            $this->ordSkuRepository->updateOrCreate($item);
                        }

                        // Log successful chunk processing
                        Log::info('Processed a chunk of order details for order ID ' . $ordHead->id);

                    } catch (\Exception $e) {
                        // Log the error if something goes wrong with the chunk processing
                        Log::error('Failed to process chunk for order ID ' . $ordHead->id, ['error' => $e->getMessage()]);
                        // Continue to the next chunk or order
                    }
                });

                // Retrieve supplier information once for each order
                $supplierNo = (string) $ordHead->supplier;
                $emailSuppliers = User::where('username', $supplierNo)->get();

                // Uncomment and customize if email notifications are needed
                // foreach ($emailSuppliers as $supplier) {
                //     $dataOrder = [
                //         'supplier_email' => $supplier->email,
                //         'supplier_name' => $supplier->name,
                //         'download_link' => env('APP_URL') . "/po/pdf?id=" . $orderData['order_no']
                //     ];
                //     Event::dispatch(new OrderStoredEvent($dataOrder));
                // }

                // Log successful order processing
                Log::info('Successfully stored order data for order no: ' . $orderData['order_no']);

            } catch (\Exception $e) {
                // Log the error if something goes wrong during the order processing
                Log::error('Failed to process order with order_no: ' . $orderData['order_no'], ['error' => $e->getMessage()]);
            }
        }

        // Return success response after all orders have been processed
        return response()->json([
            'message' => 'Data PO stored successfully',
            'title' => 'PO stored success',
        ]);
    }

}
