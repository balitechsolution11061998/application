<?php

namespace App\Http\Controllers;

use App\Models\OrdHead;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardPoController extends Controller
{
    public function index()
    {
        return view('dashboard.po.index');
    }

    public function fetchDataPerStatus(Request $request)
    {
        // Start time for performance measurement
        $startTime = microtime(true);
        $memoryBefore = memory_get_usage();

        // Enable query logging
        DB::enableQueryLog();

        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            // Get the selected store IDs from the request
            $selectedStores = $request->input('stores', []);

            // Ensure $selectedStores is an array
            if (!is_array($selectedStores)) {
                $selectedStores = [$selectedStores]; // Convert to array if it's a single string
            }

            // Convert selected store IDs from strings to integers
            $selectedStores = array_map('intval', $selectedStores);

            // Initialize query for progress
            $progressQuery = OrdHead::where('status', 'progress');
            if (!empty($selectedStores)) {
                $progressQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $progressQuery->whereBetween('created_at', [$startDate, $endDate]);
            }

            $progressCount = $progressQuery->count();
            $totalCount = OrdHead::count(); // Total count for percentage calculation

            // Calculate progress percentage
            $progressPercentage = $totalCount > 0 ? ($progressCount / $totalCount) * 100 : 0;

            // Initialize query for confirmed
            $confirmedQuery = OrdHead::where('status', 'confirmed');
            if (!empty($selectedStores)) {
                $confirmedQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $confirmedQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $confirmedCount = $confirmedQuery->count();
            $confirmedPercentage = $totalCount > 0 ? ($confirmedCount / $totalCount) * 100 : 0;

            // Initialize query for printed
            $printedQuery = OrdHead::where('status', 'printed');
            if (!empty($selectedStores)) {
                $printedQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $printedQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $printedCount = $printedQuery->count();
            $printedPercentage = $totalCount > 0 ? ($printedCount / $totalCount) * 100 : 0;

            // Initialize query for completed
            $completedQuery = OrdHead::where('status', 'completed');
            if (!empty($selectedStores)) {
                $completedQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $completedQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $completedCount = $completedQuery->count();
            $completedPercentage = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;

            // Initialize query for expired
            $expiredQuery = OrdHead::where('status', 'expired');
            if (!empty($selectedStores)) {
                $expiredQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $expiredQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $expiredCount = $expiredQuery->count();
            $expiredPercentage = $totalCount > 0 ? ($expiredCount / $totalCount) * 100 : 0;

            // Initialize query for rejected
            $rejectedQuery = OrdHead::where('status', 'rejected');
            if (!empty($selectedStores)) {
                $rejectedQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $rejectedQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $rejectedCount = $rejectedQuery->count();
            $rejectedPercentage = $totalCount > 0 ? ($rejectedCount / $totalCount) * 100 : 0;

            // Initialize query for delivery
            $deliveryQuery = OrdHead::where('status', 'delivery');
            if (!empty($selectedStores)) {
                $deliveryQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $deliveryQuery->whereBetween('created_at', [$startDate, $endDate]);
            }
            $deliveryCount = $deliveryQuery->count();
            $deliveryPercentage = $totalCount > 0 ? ($deliveryCount / $totalCount) * 100 : 0;

            // Prepare the response data
            $data = [
                'progress' => $progressCount,
                'percentage' => round($progressPercentage, 2),
                'details' => "+10% (+5% Inc)", // Example details
                'confirmed' => $confirmedCount,
                'confirmedPercentage' => round($confirmedPercentage, 2), // Round to 2 decimal places
                'printed' => $printedCount,
                'printedPercentage' => round($printedPercentage, 2), // Round to 2 decimal places
                'completed' => $completedCount,
                'completedPercentage' => round($completedPercentage, 2), // Round to 2 decimal places
                'expired' => $expiredCount,
                'expiredPercentage' => round($expiredPercentage, 2), // Round to 2 decimal places
                'rejected' => $rejectedCount,
                'rejectedPercentage' => round($rejectedPercentage, 2), // Round to 2 decimal places
                'delivery' => $deliveryCount,
                'deliveryPercentage' => round($deliveryPercentage, 2) // Round to 2 decimal places
            ];

            // Log the activity
            activity()
                ->performedOn(new OrdHead())
                ->log('Fetched progress count', [
                    'execution_time' => microtime(true) - $startTime,
                    'memory_usage' => memory_get_usage() - $memoryBefore,
                    'query_count' => count(DB::getQueryLog()),
                ]);

            // Return the data as a JSON response
            return response()->json($data);
        } catch (\Exception $e) {
            // Log the error
            activity()
                ->performedOn(new OrdHead())
                ->log('Error fetching progress count: ' . $e->getMessage(), [
                    'execution_time' => microtime(true) - $startTime,
                    'memory_usage' => memory_get_usage() - $memoryBefore,
                ]);

            // Return an error response
            return response()->json(['error' => 'Failed to fetch progress count'], 500);
        }
    }

    public function getPOCountPerDate(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedStores = $request->input('stores', []);

        // Ensure $selectedStores is an array
        if (!is_array($selectedStores)) {
            $selectedStores = [$selectedStores]; // Convert to array if it's a single string
        }

        // Convert selected store IDs from strings to integers
        $selectedStores = array_map('intval', $selectedStores);

        try {
            // Initialize the query
            $query = OrdHead::select(DB::raw('DATE(approval_date) as date'), DB::raw('count(*) as count'));

            // Apply date filtering only if both dates are provided
            if ($startDate && $endDate) {
                $query->whereBetween('approval_date', [$startDate, $endDate]);
            }
            if (!empty($selectedStores)) {
                $query->whereIn('ordhead.ship_to', $selectedStores);
            } else {
                // Optionally, you can add a condition to filter for a specific store if needed
                $query->where('ordhead.ship_to', 40); // Replace 40 with the actual identifier for the store you want to fetch
            }

            // Group by date and order by date
            $data = $query->groupBy(DB::raw('DATE(approval_date)'))
                ->orderBy(DB::raw('DATE(approval_date)'))
                ->get();

            // Prepare the response data
            $dates = $data->pluck('date')->toArray();
            $counts = $data->pluck('count')->toArray();

            // If no data is returned, ensure today's date is included
            if (empty($dates)) {
                $today = date('Y-m-d');
                $dates = [$today];
                $counts = [0]; // Assuming no orders for today
            }

            return response()->json([
                'approval_date' => $dates,
                'counts' => $counts
            ]);
        } catch (\Exception $e) {
            // Log the error using Spatie Activity Log
            activity()
                ->performedOn(new OrdHead())
                ->log('Error fetching PO count per date: ' . $e->getMessage(), [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'error' => $e->getMessage()
                ]);

            // Return an error response
            return response()->json(['error' => 'Failed to fetch PO count per date'], 500);
        }
    }
    public function getPOCountPerStore(Request $request)
    {
        // Get the selected store IDs from the request
        $selectedStores = $request->input('stores', []);

        // Ensure $selectedStores is an array
        if (!is_array($selectedStores)) {
            $selectedStores = [$selectedStores]; // Convert to array if it's a single string
        }

        // Convert selected store IDs from strings to integers
        $selectedStores = array_map('intval', $selectedStores);
        // Get the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch purchase orders grouped by ship_to and status
        try {
            $query = OrdHead::select(
                    'ordhead.ship_to',
                    'store.store_name', // Include store name from the stores table
                    'ordhead.status', // Include status in the selection
                    DB::raw('count(*) as count')
                )
                ->join('store', 'ordhead.ship_to', '=', 'store.store') // Join with the stores table
                ->groupBy('ordhead.ship_to', 'store.store_name', 'ordhead.status') // Group by ship_to, store_name, and status
                ->orderBy('store.store_name', 'asc') // Order by store_name
                ->orderBy('ordhead.status', 'asc'); // Order by status
            // If no stores are selected, fetch data for all stores
            if (!empty($selectedStores)) {
                $query->whereIn('ordhead.ship_to', $selectedStores);
            } else {
                // Optionally, you can add a condition to filter for a specific store if needed
                $query->where('ordhead.ship_to', 40); // Replace 40 with the actual identifier for the store you want to fetch
            }

            // Apply date filtering if both start and end dates are provided
            if ($startDate && $endDate) {
                $query->whereBetween('ordhead.approval_date', [$startDate, $endDate]); // Adjust the column name as necessary
            }

            $data = $query->get();

            // Prepare the response
            $categories = [];
            $counts = [];

            // Structure the response to include counts per store and status
            foreach ($data as $item) {
                $categories[] = $item->store_name . ' - ' . $item->status . ' (' . $item->count . ')'; // Include count in the category
                $counts[] = $item->count; // Get the counts
            }

            return response()->json([
                'categories' => $categories,
                'counts' => $counts,
            ]);
        } catch (\Exception $e) {
            // Log the error using Spatie Activity Log
            activity()
                ->performedOn(new OrdHead())
                ->log('Error fetching PO count per store: ' . $e->getMessage(), [
                    'error' => $e->getMessage()
                ]);

            // Return an error response
            return response()->json(['error' => 'Failed to fetch PO count per store'], 500);
        }
    }


}
