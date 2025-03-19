<?php

namespace App\Http\Controllers;

use App\Helpers\SystemUsageHelper;
use App\Models\OrderConfirmationHistory;
use App\Models\OrdHead;
use App\Models\OrdSku;
use App\Models\PrintHistory;
use App\Models\RejectedOrder;
use App\Models\SupplierQuantity;
use App\Services\Order\OrderService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Facades\Activity;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http; // For making HTTP requests
use Pusher\Pusher; // For Pusher integration
use App\Traits\ActivityLogger;

class OrderController extends Controller
{
    use ActivityLogger;
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function printPo(Request $request)
    {
        try {
            // Start time measurement
            $startTime = microtime(true);

            // Get the order number and cast it to an integer
            $orderNo = (int) $request->input('order_no');

            // Log the print history
            $printHistory = PrintHistory::create([
                'order_no' => $orderNo,
                'printed_by' => Auth::user()->username, // Assuming you have a username field in your User model
            ]);

            // Retrieve the Ordhead instance
            $ordhead = Ordhead::where('order_no', $orderNo)->first();

            // Check if the order exists
            if (!$ordhead) {
                throw new \Exception('Order not found.');
            }

            // Update the ordhead table to set the status to 'Printed'
            $ordheadUpdated = $ordhead->update(['status' => 'Printed']);

            // Get supplier and store information
            $supplier = $ordhead->suppliers; // Assuming the relationship is defined correctly
            $store = $ordhead->stores; // Assuming the relationship is defined correctly

            $supplierName = $supplier ? $supplier->supp_name : 'Unknown Supplier';
            $supplierAddress = $supplier ? $supplier->address_1 . ', ' . $supplier->city : 'N/A'; // Adjust according to your address fields

            $storeName = $store ? $store->store_name : 'Unknown Store';
            $storeAddress = $store ? $store->store_add1 . ', ' . $store->store_city : 'N/A'; // Adjust according to your address fields

            // Check if the update was successful
            if ($ordheadUpdated) {
                // Calculate the time taken for the print operation
                $endTime = microtime(true);
                $executionTime = $endTime - $startTime; // Time in seconds

                // Get memory usage
                $memoryUsed = memory_get_usage(); // Memory used in bytes

                // Log the activity for successful print with additional properties
                activity('Print PO')
                    ->performedOn($printHistory)
                    ->causedBy(Auth::user())
                    ->withProperties([
                        'order_no' => $orderNo,
                        'execution_time' => $executionTime,
                        'memory_used' => $memoryUsed,
                    ])
                    ->log('Printed PO: ' . $orderNo);

                // Send Telegram notification
                $status = 'Printed'; // Status to send

                $this->sendTelegramNotification($orderNo, [], $status, $supplierName, $supplierAddress, $storeName, $storeAddress,false,true);

                return response()->json(['success' => true, 'message' => 'PO printed successfully.']);
            } else {
                // If the update did not affect any rows, log an error
                throw new \Exception('Failed to update order status.');
            }
        } catch (\Exception $e) {
            // Log the activity for failed print with error details
            activity('Print PO Error')
                ->causedBy(Auth::user())
                ->withProperties([
                    'order_no' => $request->input('order_no'),
                    'error_message' => $e->getMessage(),
                ])
                ->log('Failed to print PO: ' . $request->input('order_no'));

            return response()->json(['success' => false, 'message' => 'Failed to print PO: ' . $e->getMessage()], 500);
        }
    }



    public function getDeliveryItems($order_no)
    {
        $order_no = base64_decode($order_no);

        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Fetch the order with related SKU data
        $order = OrdHead::with('ordsku')->where('order_no', $order_no)->first();

        // Check if the order exists
        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        // Check if the order has SKU items
        if ($order->ordsku->isEmpty()) {
            return response()->json(['message' => 'No items found for this order.'], 204); // No Content
        }


        // Prepare the response data
        $responseData = [];
        foreach ($order->ordsku as $sku) {
            $responseData[] = [
                'sku' => $sku->sku, // SKU code
                'sku_desc' => $sku->sku_desc, // SKU description
                'supplier_code' => $order->supplier, // Assuming supplier is directly on OrdHead
                'qty_ordered' => $sku->qty_ordered,
            ];
        }

        return response()->json($responseData);
    }



    public function showOrderSupplier($order_no)
    {
        $order_no = base64_decode($order_no);

        // Capture start time and memory usage
        $startTime = microtime(true);
        $startMemory = memory_get_usage(); // Memory in bytes

        try {
            // Check if the user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login'); // Redirect to login if not authenticated
            }

            // Fetch the order to log it as the subject
            $order = OrdHead::where('order_no', $order_no)->first();
            if (!$order) {
                return redirect()->back()->with([
                    'message' => 'Order not found.',
                    'code' => 404,
                ]);
            }

            // Get the user's IP address
            $userIp = request()->ip();

            // Log activity: User is viewing an order
            activity()
                ->causedBy(Auth::user())
                ->performedOn($order) // Set the subject to the order
                ->withProperties([
                    'order_no' => $order_no,
                    'execution_time_ms' => round((microtime(true) - $startTime) * 1000, 2), // Time in ms
                    'memory_usage_m' => round($startMemory / 1024 / 1024, 2), // Memory in M
                    'timestamp' => now(),
                    'log_name' => 'Custom Log Name: Viewed Order', // Custom log name
                    'user_ip' => $userIp, // Add user IP address
                ])
                ->log('User accessed order details'); // Custom log message

            // Fetch order details with related store and supplier information
            $orderDetails = $this->getOrderDetails($order_no);
            // dd($orderDetails);


            // Check if the order exists
            if (!$orderDetails) {
                return view('orders.notfound'); // Render a "not found" view
            }

            // Fetch all order items (ordsku details)
            $orderItems = $this->getOrderItems($order_no);

            // Prepare data for the view
            $data = $this->prepareOrderData($orderDetails, $orderItems);

            // Log system usage
            // SystemUsageHelper::logUsage($startTime, $startMemory, now(), 'orderData');

            // Return the view with data
            return view('frontend.po.show', compact('data'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Log system usage in case of an error
            // SystemUsageHelper::logUsage($startTime, $startMemory, now(), 'orderDataError');

            // Log the exception details for debugging
            activity()
                ->causedBy(Auth::user())
                ->withProperties([
                    'order_no' => $order_no,
                    'error' => $e->getMessage(),
                    'execution_time_ms' => round((microtime(true) - $startTime) * 1000, 2), // Time in ms
                    'memory_usage_m' => round($startMemory / 1024 / 1024, 2), // Memory in M
                    'timestamp' => now(),
                    'log_name' => 'Custom Log Name: Error Viewing Order', // Custom log name
                    'user_ip' => $userIp, // Add user IP address
                ])
                ->log('Error accessing order details'); // Custom log message

            // Return back with an error message and status code
            return redirect()->back()->with([
                'message' => 'An error occurred while retrieving the order details.',
                'error' => $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    public function confirmOrder(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'confirmation_date' => 'required|date',
            'order_no' => 'required|string',
        ]);

        // Decode the order number
        $orderNo = base64_decode($request->order_no);

        // Start measuring time and memory
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            // Insert into the order confirmation history table
            OrderConfirmationHistory::create([
                'order_no' => $orderNo,
                'confirmation_date' => $request->confirmation_date,
                'username' => Auth::user()->username, // Assuming you have a user_id column in the history table
            ]);

            // Update the order status to confirmed
            $order = OrdHead::where('order_no', $orderNo)->first(); // Assuming order_no is the ID
            if ($order) {
                $order->status = 'Confirmed'; // Update the status
                $order->save(); // Save the changes

                // Get supplier and store information
                $supplier = $order->suppliers; // Assuming the relationship is defined correctly
                $store = $order->stores; // Assuming the relationship is defined correctly

                $supplierName = $supplier ? $supplier->supp_name : 'Unknown Supplier';
                $supplierAddress = $supplier ? $supplier->address_1 . ', ' . $supplier->city : 'N/A'; // Adjust according to your address fields

                $storeName = $store ? $store->store_name : 'Unknown Store';
                $storeAddress = $store ? $store->store_add1 . ', ' . $store->store_city : 'N/A'; // Adjust according to your address fields

                // Log the activity with supplier and store details
                activity('Confirmed Order')
                    ->performedOn(new OrderConfirmationHistory())
                    ->withProperties([
                        'order_no' => $orderNo,
                        'confirmation_date' => $request->confirmation_date,
                        'execution_time' => microtime(true) - $startTime,
                        'memory_used' => memory_get_usage() - $startMemory,
                        'username' => Auth::user()->username, // Log the user ID
                        'supplier_name' => $supplierName,
                        'supplier_address' => $supplierAddress,
                        'store_name' => $storeName,
                        'store_address' => $storeAddress,
                    ])
                    ->log('Order confirmed with supplier and store details');

                // Send Telegram notification
                $this->sendTelegramNotification($orderNo, [], 'Confirmed', $supplierName, $supplierAddress, $storeName, $storeAddress, true,false);

                return response()->json(['message' => 'Order confirmed successfully!']);
            }

            return response()->json(['error' => 'Order not found.'], 404);
        } catch (\Exception $e) {
            // Log the error
            activity('Error Confirmed Order')
                ->performedOn(new OrderConfirmationHistory())
                ->withProperties([
                    'error' => $e->getMessage(),
                    'username' => Auth::user()->username, // Log the user ID
                ])
                ->log('Error confirming order');

            return response()->json(['error' => 'Error confirming order: ' . $e->getMessage()], 500);
        }
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all(); // Get the orders array

            foreach ($data as $chunk) {
                // Call the orderService for each chunk
                $this->orderService->store($chunk);

                // Log each action in Spatie Activity Log
                activity()
                    ->causedBy(auth()->user()) // Log the user who performed the action
                    ->withProperties(['chunk' => $chunk]) // Optional: Log chunk details
                    ->log('Stored a new Purchase Order');
            }

            // Return success response
            return response()->json([
                'message' => 'Data PO stored successfully',
                'title' => 'PO Stored Success',
            ]);
        } catch (Exception $e) {
            // Log the exception in Spatie Activity Log
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['error' => $e->getMessage()])
                ->log('Failed to store Purchase Order');

            // Return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delivery(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'deliveryData' => 'required|array',
            'deliveryData.*.sku' => 'required|string',
            'deliveryData.*.qtyToDeliver' => 'required|integer|min:0',
            'deliveryData.*.reason' => 'nullable|string',
            'orderNo' => 'required|string', // Validate orderNo
            'confirmationDate' => 'required|date', // Validate confirmation date
        ]);

        // Extract the delivery data from the request
        $deliveryData = $request->input('deliveryData');
        $orderNo = $request->input('orderNo');



        // Convert confirmation date to a Carbon instance
        $confirmationDate = Carbon::parse($request->input('confirmationDate'));

        // Start time for performance measurement
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            // Insert delivery items into the database
            foreach ($deliveryData as $item) {
                SupplierQuantity::create([
                    'order_no' => $orderNo,
                    'sku' => $item['sku'], // Assuming SKU is used as supplier code
                    'available_quantity' => (int)$item['qtyToDeliver'], // Ensure it's an integer
                    'reason' => $item['reason'] ?? null, // Save the reason if provided
                ]);
            }

            // Update the Ordhead status to "Delivery"
            $ordhead = Ordhead::where('order_no', $orderNo)->first();
            if ($ordhead) {
                $ordhead->update([
                    'status' => 'Delivery', // Update the status
                    'estimated_delivery_date' => $confirmationDate, // Use the Carbon instance
                    'delivery_date' => $confirmationDate, // Use the Carbon instance
                ]);

                // Log the activity for updating Ordhead
                activity('Update_Purchase_Order_To_Delivery')
                    ->performedOn($ordhead)
                    ->causedBy(auth()->user()) // Assuming you have user authentication
                    ->withProperties($this->getActivityProperties($startTime, $startMemory, $orderNo))
                    ->log('Order status updated to Delivery for order: ' . $orderNo);

                // Check if the delivery date is today
                if ($confirmationDate->isToday()) {
                    // Get supplier and store information
                    $supplier = $ordhead->suppliers; // Assuming the relationship is defined correctly
                    $store = $ordhead->stores; // Assuming the relationship is defined correctly

                    $supplierName = $supplier ? $supplier->supp_name : 'Unknown Supplier';
                    $supplierAddress = $supplier ? $supplier->address_1 . ', ' . $supplier->city : 'N/A'; // Adjust according to your address fields

                    $storeName = $store ? $store->store_name : 'Unknown Store';
                    $storeAddress = $store ? $store->store_add1 . ', ' . $store->store_city : 'N/A'; // Adjust according to your address fields

                    // Send notification to Telegram
                    $this->sendTelegramNotification($orderNo, $deliveryData, 'Delivery', $supplierName, $supplierAddress, $storeName, $storeAddress);

                    // Push message to Pusher
                    // $this->pushToChat($orderNo, $deliveryData);
                }
            }

            // Log the activity for saving delivery quantities
            activity("Insert to Supplier Quantity")
                ->performedOn(new SupplierQuantity())
                ->causedBy(auth()->user()) // Assuming you have user authentication
                ->withProperties($this->getActivityProperties($startTime, $startMemory, $orderNo))
                ->log('Delivery quantities saved for order: ' . $orderNo);

            return response()->json(['message' => 'Delivery quantities saved successfully.'], 200);
        } catch (\Exception $e) {
            // Log the error message
            dd($e->getMessage());
            // Log the activity for the error
            activity()
                ->causedBy(auth()->user()) // Assuming you have user authentication
                ->withProperties(array_merge($this->getActivityProperties($startTime, $startMemory, $orderNo), [
                    'error_message' => $e->getMessage(),
                ]))
                ->log('Failed to save delivery quantities for order: ' . $orderNo);

            return response()->json(['message' => 'Failed to save delivery quantities. Please try again.'], 500);
        }
    }


    private function sendTelegramNotification($orderNo, $deliveryData, $status, $supplierName, $supplierAddress, $storeName, $storeAddress, $isConfirmation = false, $isPrint = false)
    {
        // Create a more engaging message
        $message = "📦 **" . ($isConfirmation ? "Order Confirmation" : ($isPrint ? "Order Printed" : "Delivery Update")) . "** 📦\n\n";
        $message .= "🚚 *Order No:* **$orderNo**\n\n";
        $message .= "🏢 *Supplier:* **$supplierName**\n";
        $message .= "🏠 *Supplier Address:* **$supplierAddress**\n\n";
        $message .= "🏬 *Store:* **$storeName**\n";
        $message .= "🏠 *Store Address:* **$storeAddress**\n\n";
        $message .= "🎉 *Status:* **$status**\n\n"; // Use the status parameter

        // Add details if it's a delivery update
        if (!$isConfirmation && !$isPrint) {
            $message .= "📋 *Delivery Details:*\n";
            foreach ($deliveryData as $item) {
                $message .= "🔹 *SKU:* `{$item['sku']}`\n";
                $message .= "🔹 *Quantity:* `{$item['qtyToDeliver']}`\n";
                $message .= "🔹 *Reason:* `" . (!empty($item['reason']) ? $item['reason'] : 'N/A') . "`\n\n"; // Indicate no reason if empty
            }
        }

        // Encode the order number for the URL
        $encodedOrderNo = base64_encode($orderNo); // Base64 encode the order number
        // Add a link to the details
        $detailsUrl = url(($isConfirmation ? "/purchase-orders/show/{$encodedOrderNo}" : ($isPrint ? "/print/order/{$encodedOrderNo}" : "/delivery/details/{$encodedOrderNo}"))); // Adjust the URL as necessary
        $message .= "🔗 *View Details:* [Click Here]($detailsUrl)\n\n";

        $message .= "🙏 Thank you for your attention! If you have any questions, feel free to reach out. 😊";

        // Send the message to Telegram
        $this->sendMessageToTelegram($message, $orderNo);
    }

    private function sendMessageToTelegram($message, $orderNo)
    {
        $telegramToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID'); // This should be the channel username or ID
        $url = "https://api.telegram.org/bot$telegramToken/sendMessage";

        try {
            // Send the message to Telegram
            $response = Http::post($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown', // Use Markdown for formatting
            ]);

            // Check if the response is successful
            if ($response->successful()) {
                activity('Telegram Notification Sent')
                    ->withProperties([
                        'order_no' => $orderNo,
                        'message' => $message,
                    ])
                    ->log('Telegram notification sent successfully for order: ' . $orderNo);
            } else {
                $errorMessage = $response->json()['description'] ?? 'Unknown error';
                activity('Telegram Notification Failed')
                    ->withProperties([
                        'order_no' => $orderNo,
                        'error' => $response->body(),
                    ])
                    ->log('Failed to send Telegram notification for order: ' . $orderNo . '. Error: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            // Log the exception
            activity('Telegram Notification Exception')
                ->withProperties([
                    'order_no' => $orderNo,
                    'error_message' => $e->getMessage(),
                ])
                ->log('Exception occurred while sending Telegram notification for order: ' . $orderNo);
        }
    }







    /**
     * Push a message to Pusher chat.
     *
     * @param string $orderNo
     * @param array $deliveryData
     * @return void
     */
    private function pushToChat($orderNo, $deliveryData)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $message = [
            'orderNo' => $orderNo,
            'deliveryData' => $deliveryData,
        ];

        $pusher->trigger('delivery-channel', 'new-delivery', $message);
    }

    /**
     * Get activity properties for logging.
     *
     * @param float $startTime
     * @param int $startMemory
     * @param string $orderNo
     * @return array
     */
    private function getActivityProperties($startTime, $startMemory, $orderNo)
    {
        return [
            'time_taken' => microtime(true) - $startTime,
            'memory_used' => memory_get_usage() - $startMemory,
            'order_no' => $orderNo,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($order_no)
    {
        $order_no = base64_decode($order_no);

        // Capture start time and memory usage
        $startTime = microtime(true);
        $startMemory = memory_get_usage(); // Memory in bytes

        try {
            // Check if the user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login'); // Redirect to login if not authenticated
            }

            // Fetch the order to log it as the subject
            $order = OrdHead::where('order_no', $order_no)->first();
            if (!$order) {
                return redirect()->back()->with([
                    'message' => 'Order not found.',
                    'code' => 404,
                ]);
            }

            // Get the user's IP address
            $userIp = request()->ip();

            // Log activity: User is viewing an order
            activity()
                ->causedBy(Auth::user())
                ->performedOn($order) // Set the subject to the order
                ->withProperties([
                    'order_no' => $order_no,
                    'execution_time_ms' => round((microtime(true) - $startTime) * 1000, 2), // Time in ms
                    'memory_usage_m' => round($startMemory / 1024 / 1024, 2), // Memory in M
                    'timestamp' => now(),
                    'log_name' => 'Custom Log Name: Viewed Order', // Custom log name
                    'user_ip' => $userIp, // Add user IP address
                ])
                ->log('User accessed order details'); // Custom log message

            // Fetch order details with related store and supplier information
            $orderDetails = $this->getOrderDetails($order_no);

            // Check if the order exists
            if (!$orderDetails) {
                return view('orders.notfound'); // Render a "not found" view
            }

            // Fetch all order items (ordsku details)
            $orderItems = $this->getOrderItems($order_no);

            // Prepare data for the view
            $data = $this->prepareOrderData($orderDetails, $orderItems);

            // Log system usage
            // SystemUsageHelper::logUsage($startTime, $startMemory, now(), 'orderData');

            // Return the view with data
            return view('orders.show', compact('data'));
        } catch (\Exception $e) {
            // Log system usage in case of an error
            // SystemUsageHelper::logUsage($startTime, $startMemory, now(), 'orderDataError');

            // Log the exception details for debugging
            activity()
                ->causedBy(Auth::user())
                ->withProperties([
                    'order_no' => $order_no,
                    'error' => $e->getMessage(),
                    'execution_time_ms' => round((microtime(true) - $startTime) * 1000, 2), // Time in ms
                    'memory_usage_m' => round($startMemory / 1024 / 1024, 2), // Memory in M
                    'timestamp' => now(),
                    'log_name' => 'Custom Log Name: Error Viewing Order', // Custom log name
                    'user_ip' => $userIp, // Add user IP address
                ])
                ->log('Error accessing order details'); // Custom log message

            // Return back with an error message and status code
            return redirect()->back()->with([
                'message' => 'An error occurred while retrieving the order details.',
                'error' => $e->getMessage(),
                'code' => 500,
            ]);
        }
    }

    public function getOrdersSupplier()
    {
        return view('frontend.po.index');
    }





    private function getOrderDetails($order_no)
    {
        return DB::table('ordhead')
            ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store')
            ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code')
            ->leftJoin('rcvhead', 'ordhead.order_no', '=', 'rcvhead.order_no')
            ->leftJoin('rcvdetail', 'rcvdetail.receive_no', '=', 'rcvhead.receive_no')
            ->leftJoin('print_histories', 'print_histories.order_no', '=', 'ordhead.order_no')
            ->leftJoin('order_confirmation_histories', 'order_confirmation_histories.order_no', '=', 'ordhead.order_no')
            ->leftJoin('users as confirmation_user', 'confirmation_user.username', '=', 'order_confirmation_histories.username') // Alias for confirmation user
            ->leftJoin('users as printed_user', 'printed_user.username', '=', 'print_histories.printed_by') // Alias for printed user
            ->select(
                'ordhead.*',
                'store.store as store_code',
                'store.store_name as store_name',
                'store.store_add1 as store_address',
                'store.store_add2 as store_address1',
                'store.store_city as store_city',
                'store.latitude',
                'store.longitude',
                'supplier.supp_code as supplier_code',
                'supplier.supp_name as supplier_name',
                'supplier.contact_name as supplier_contact',
                'supplier.contact_phone as supplier_phone',
                'supplier.address_1 as supp_address',
                'supplier.tax_ind as tax_ind',
                'rcvhead.receive_date as receive_date',
                'rcvhead.receive_no as receive_no',
                'rcvdetail.*', // Include all fields from rcvdetail
                'print_histories.printed_at',
                'order_confirmation_histories.confirmation_date',
                'order_confirmation_histories.username as confirmation_by',
                'confirmation_user.name as confirmation_user_name', // Use alias for confirmation user
                'printed_user.name as printed_user_name' // Use alias for printed user
            )
            ->where('ordhead.order_no', $order_no)
            ->first();
    }



    private function getOrderItems($order_no)
    {
        return OrdSku::with('itemSupplier')
            ->where('ordsku.order_no', $order_no)
            ->select(
                'ordsku.sku',
                'ordsku.sku_desc',
                'ordsku.upc',
                'ordsku.tag_code',
                DB::raw('SUM(ordsku.qty_ordered) as qty_ordered'),
                DB::raw('SUM(ordsku.unit_cost) as unit_cost'),
                'ordsku.unit_retail',
                'ordsku.vat_cost',
                'ordsku.luxury_cost',
                'ordsku.qty_fulfilled',
                'ordsku.qty_received',
                'ordsku.unit_discount',
                'ordsku.unit_permanent_discount',
                'ordsku.purchase_uom',
                'ordsku.supp_pack_size',
                'ordsku.permanent_disc_pct',
                'ordsku.created_at',
                'ordsku.updated_at'
            )
            ->groupBy('ordsku.sku', 'ordsku.sku_desc', 'ordsku.upc', 'ordsku.tag_code', 'ordsku.unit_retail', 'ordsku.vat_cost', 'ordsku.luxury_cost', 'ordsku.qty_fulfilled', 'ordsku.qty_received', 'ordsku.unit_discount', 'ordsku.unit_permanent_discount', 'ordsku.purchase_uom', 'ordsku.supp_pack_size', 'ordsku.permanent_disc_pct', 'ordsku.created_at', 'ordsku.updated_at')
            ->get();
    }

    private function prepareOrderData($orderDetails, $orderItems)
    {
        return [
            'orderDetails' => $orderDetails,
            'store' => [
                'store_code' => $orderDetails->store_code,
                'store_name' => $orderDetails->store_name,
                'store_address' => $orderDetails->store_address,
                'store_address1' => $orderDetails->store_address1,
                'store_city' => $orderDetails->store_city,
                'latitude' => $orderDetails->latitude,
                'longitude' => $orderDetails->longitude,
            ],
            'supplier' => [
                'supplier_code' => $orderDetails->supplier_code,
                'supplier_name' => $orderDetails->supplier_name,
                'supplier_contact' => $orderDetails->supplier_contact,
                'supplier_phone' => $orderDetails->supplier_phone,
                'supp_address' => $orderDetails->supp_address,
                'tax_ind' => $orderDetails->tax_ind,
            ],
            'orderItems' => $orderItems,
        ];
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            try {
                // Start tracking performance
                $startTime = microtime(true);
                $startMemory = memory_get_usage();

                // Base query with joins and selections
                $query = DB::table('ordhead')
                    ->leftJoin('rcvhead','rcvhead.order_no','=','ordhead.order_no')
                    ->leftJoin('ordsku', 'ordsku.order_no', '=', 'ordhead.order_no')
                    ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store')
                    ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code')
                    ->select(
                        'ordhead.*',
                        'store.store as store',
                        'store.store_name as store_name',
                        'supplier.supp_code as supp_code',
                        'supplier.supp_name as supp_name',
                        'ordhead.not_after_date as expired_date',
                        'ordhead.approval_date as approval_date',
                        'rcvhead.receive_no',
                        'rcvhead.receive_date'
                    )
                    ->distinct()
                    ->orderBy('approval_date', 'desc');

                // Check if the user has the 'supplier' role
                if (Auth::user()->hasRole('supplier')) {
                    // Filter by supplier_id if the user is a supplier
                    $supplierIds = explode(',', Auth::user()->supplier_id);
                    $query->whereIn('ordhead.supplier', $supplierIds);
                }

                // Apply filters
                if (!empty($request->orderNo)) {
                    $query->where('ordhead.order_no', $request->orderNo);
                }
                if (!empty($request->store)) {
                    $query->whereIn('ordhead.ship_to', $request->store); // Filter by store
                }
                if (!empty($request->supplier)) {
                    $query->whereIn('ordhead.supplier', $request->supplier); // Filter by supplier
                }
                if (!empty($request->supplier)) {
                    $query->whereIn('ordhead.status', $request->status); // Filter by supplier
                }

                if (!empty($request->status)) {
                    $query->whereIn('ordhead.status', $request->status); // Filter by supplier
                }

                if (!empty($request->startDate) && !empty($request->endDate)) {
                    // Convert date format from MM/DD/YYYY to DD-MM-YYYY
                    $startDate = DateTime::createFromFormat('m/d/Y', $request->startDate)->format('Y-m-d');
                    $endDate = DateTime::createFromFormat('m/d/Y', $request->endDate)->format('Y-m-d');

                    $query->whereBetween('ordhead.approval_date', [$startDate, $endDate]);
                }

                // Prepare results for DataTables using chunking
                $results = [];
                $query->chunk(1000, function ($chunk) use (&$results) {
                    foreach ($chunk as $row) {
                        $results[] = $row;
                    }
                });

                // Transform the results for DataTables
                return DataTables::of($results)
                    ->addColumn('action', function ($row) {
                        return '<button type="button" class="btn btn-sm btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-docs-datatable-subtable="expand_row">
                                    <span class="svg-icon fs-3 m-0 toggle-off">...</span>
                                    <span class="svg-icon fs-3 m-0 toggle-on">...</span>
                                </button>';
                    })
                    ->editColumn('total_cost', function ($row) {
                        return '$' . number_format($row->total_cost, 2);
                    })
                    ->editColumn('total_retail', function ($row) {
                        return '$' . number_format($row->total_retail, 2);
                    })
                    ->rawColumns(['action']) // Allow HTML rendering
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while fetching data. ' . $e->getMessage()], 500);
            } finally {
                // Log performance metrics
                $executionTimeMs = round((microtime(true) - $startTime) * 1000, 2); // Time in ms
                $memoryUsageM = round((memory_get_usage() - $startMemory) / 1024 / 1024, 2); // Memory in MB

                // Log performance metrics
                $lastOrder = OrdHead::latest()->first(); // Get the last order for logging
                if ($lastOrder) {
                    activity('Show List Purchase Order')
                        ->causedBy(Auth::user()) // Log the user who triggered the action
                        ->performedOn($lastOrder) // Log the last order as the subject
                        ->withProperties([
                            'execution_time' => $executionTimeMs . " MS",
                            'memory_usage' => $memoryUsageM . " MB",
                            'timestamp' => now(),
                            'log_name' => 'Custom Log Name: Order Data Fetch', // Custom log name
                        ])
                        ->log('Fetched order data'); // Custom log message
                }

                // SystemUsageHelper::logUsage($startTime, $startMemory, now(), 'orderData');
            }
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($order_no)
    {
        try {
            // Fetch order details with related store and supplier information
            $orderDetails = DB::table('ordhead')
                ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store')
                ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code')
                ->select(
                    'ordhead.*', // Select all columns from ordhead
                    'store.store as store_code',
                    'store.store_name as store_name',
                    'store.store_add1 as store_address',
                    'store.store_add2 as store_address1',
                    'store.store_city as store_city',
                    'store.latitude', // Include latitude
                    'store.longitude', // Include longitude
                    'supplier.supp_code as supplier_code',
                    'supplier.supp_name as supplier_name',
                    'supplier.contact_name as supplier_contact',
                    'supplier.contact_phone as supplier_phone',
                    'supplier.address_1 as supp_address',

                )
                ->where('ordhead.order_no', $order_no)
                ->first();

            // Fetch all order items (ordsku details)
            $orderItems = DB::table('ordsku')
                ->where('ordsku.order_no', $order_no)
                ->select(
                    'ordsku.id',
                    'ordsku.sku',
                    'ordsku.sku_desc',
                    'ordsku.upc',
                    'ordsku.tag_code',
                    'ordsku.unit_cost',
                    'ordsku.unit_retail',
                    'ordsku.vat_cost',
                    'ordsku.luxury_cost',
                    'ordsku.qty_ordered',
                    'ordsku.qty_fulfilled',
                    'ordsku.qty_received',
                    'ordsku.unit_discount',
                    'ordsku.unit_permanent_discount',
                    'ordsku.purchase_uom',
                    'ordsku.supp_pack_size',
                    'ordsku.permanent_disc_pct',
                    'ordsku.created_at',
                    'ordsku.updated_at'
                )
                ->get();

            // Check if the order exists
            if (!$orderDetails) {
                return response()->json([
                    'message' => 'Order not found.',
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            // Prepare response with order details and line items
            $response = [
                'order_details' => [
                    'orderDetails' => $orderDetails,
                    'store' => [
                        'store_code' => $orderDetails->store_code,
                        'store_name' => $orderDetails->store_name,
                        'store_address' => $orderDetails->store_address,
                        'store_address1' => $orderDetails->store_address1,
                        'store_city' => $orderDetails->store_city,
                        'latitude' => $orderDetails->latitude, // Add latitude
                        'longitude' => $orderDetails->longitude, // Add longitude
                    ],
                    'supplier' => [
                        'supplier_code' => $orderDetails->supplier_code,
                        'supplier_name' => $orderDetails->supplier_name,
                        'supplier_contact' => $orderDetails->supplier_contact,
                        'supplier_phone' => $orderDetails->supplier_phone,
                        'supp_address' => $orderDetails->supp_address,
                    ],
                ],
                'order_items' => $orderItems
            ];

            // Return success response
            return response()->json([
                'message' => 'Order details retrieved successfully.',
                'data' => $response,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'message' => 'An error occurred while retrieving the order details.',
                'data' => null,
                'code' => 500,
                'error' => $e->getMessage(),
            ], 500);
        }
    }






    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function rejectOrder(Request $request, $order_no)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate the request
            $request->validate([
                'reason' => 'required|string|max:255',
            ]);

            // Find the order
            $order = OrdHead::where('order_no', $order_no)->firstOrFail(); // Use firstOrFail for automatic 404 response

            // Create a new rejected order record
            $rejectedOrder = new RejectedOrder();
            $rejectedOrder->order_no = $order->order_no;
            $rejectedOrder->reason = $request->reason;
            $rejectedOrder->save();

            // Update the order status
            $order->status = "Rejected"; // Use a consistent status string
            $order->save();

            // Log the activity
            $this->logActivity(
                'Order rejected', // Message
                $order, // Subject (the order being rejected)
                'order_rejection', // Event name
                $request, // Request object
                null, // Start time (optional)
                null, // Memory before (optional)
                ['order_no' => $order->order_no, 'reason' => $request->reason] // Additional properties
            );

            // Commit the transaction
            DB::commit();

            // Return a JSON response
            return response()->json(['message' => 'Order rejected successfully.', 'order_no' => $order->order_no], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Log the error for debugging (optional)
            \Log::error('Error rejecting order: ' . $e->getMessage());

            // Return a JSON response with a generic error message
            return response()->json(['message' => 'An error occurred while rejecting the order.'], 500);
        }
    }




    // Method to view rejected orders
    public function rejectedOrders()
    {
        $rejectedOrders = RejectedOrder::with('order')->get(); // Assuming you have a relationship defined
        return view('rejected_orders.index', compact('rejectedOrders')); // Return a view with rejected orders
    }
}
