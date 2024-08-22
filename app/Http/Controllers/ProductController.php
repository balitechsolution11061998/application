<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('products.index');
    }

    public function getData(Request $request)
    {
        $products = Product::select([
            'product_name',
            'category',
            'brand',
            'type',
            'seller_name',
            'price',
            'buyer_sku_code',
            'stock',
            'buyer_product_status as status'
        ]);

        return DataTables::of($products)->make(true);
    }

    public function syncData(Request $request)
    {
        try {
            // Prepare the raw JSON payload
            $payload = [
                "cmd" => "prepaid",
                "username" => "jeyubaoPjxvW",
                "sign" => "1f95978f81f544820a717e8fb67cd17a"
            ];

            // Send a POST request with the raw JSON payload
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api.digiflazz.com/v1/price-list', $payload);

            // Log or dd the response to inspect its contents
            // Uncomment the line below to debug the raw response body
            // dd($response->body());

            // Decode the JSON response
            $responseData = $response->json();
            // Check if the 'data' key exists and is an array
            if (isset($responseData['data']) && is_array($responseData['data'])) {
                $externalProducts = $responseData['data'];

                // Sync each product
                foreach ($externalProducts as $externalProduct) {
                    Product::updateOrCreate(
                        ['buyer_sku_code' => $externalProduct['buyer_sku_code']],
                        [
                            'product_name' => $externalProduct['product_name'],
                            'category' => $externalProduct['category'],
                            'brand' => $externalProduct['brand'],
                            'type' => $externalProduct['type'],
                            'seller_name' => $externalProduct['seller_name'],
                            'price' => $externalProduct['price'],
                            'stock' => $externalProduct['stock'],
                            'buyer_product_status' => $externalProduct['buyer_product_status'],
                            'seller_product_status' => $externalProduct['seller_product_status'],
                            'unlimited_stock' => $externalProduct['unlimited_stock'],
                            'start_cut_off' => $externalProduct['start_cut_off'],
                            'end_cut_off' => $externalProduct['end_cut_off'],
                            'desc' => $externalProduct['desc'],
                            'multi' => $externalProduct['multi'] == true ? 0 : 1, // Set 0 if true, 1 if false
                        ]
                    );
                }

                return response()->json(['message' => 'Data synced successfully']);
            } else {
                // Handle unsuccessful responses or unexpected response format
                return response()->json([
                    'message' => 'Failed to sync data',
                    'error' => 'Invalid response format or no data found'
                ], 500);
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'message' => 'An error occurred during sync',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
