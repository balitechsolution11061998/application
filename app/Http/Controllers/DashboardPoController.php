<?php

namespace App\Http\Controllers;

use App\Models\OrdHead;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardPoController extends Controller
{
    public function index()
    {
        // Add custom JavaScript file
        addJavascriptFile('/js/dashboard/po/index.js');
    
        // Add AMCharts library files 
        // Return the view
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
            $progressQuery = DB::table('ordhead')->where('status', 'progress');

            if (!empty($startDate) && !empty($endDate)) {
                dd('masuk sini');
                $progressQuery->whereBetween('approval_date', [$startDate, $endDate]);
                if (!empty($selectedStores)) {
                    $progressQuery->whereIn('ship_to', $selectedStores);
                }

            }

            $progressCount = $progressQuery->count();
            dd($progressCount);

            // First, get the total count of purchase orders without any filtering
            $totalCountQuery = OrdHead::select(DB::raw('count(*) as total_count'));

            // Get the total count result
            $totalCountResult = $totalCountQuery->first();
            $totalCount = $totalCountResult->total_count; // Access the total_count property

            // Calculate progress percentage
            $progressPercentage = $totalCount > 0 ? ($progressCount / $totalCount) * 100 : 0;

            // Initialize query for confirmed
            $confirmedQuery = OrdHead::where('status', 'confirmed');
            if (!empty($selectedStores)) {
                $confirmedQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $confirmedQuery->whereBetween('approval_date', [$startDate, $endDate]);
            }
            $confirmedCount = $confirmedQuery->count();
            $confirmedPercentage = $totalCount > 0 ? ($confirmedCount / $totalCount) * 100 : 0;

            // Initialize query for printed
            $printedQuery = OrdHead::where('status', 'printed');
            if (!empty($selectedStores)) {
                $printedQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $printedQuery->whereBetween('approval_date', [$startDate, $endDate]);
            }
            $printedCount = $printedQuery->count();
            $printedPercentage = $totalCount > 0 ? ($printedCount / $totalCount) * 100 : 0;

            // Initialize query for completed
            $completedQuery = OrdHead::where('status', 'completed');
            if (!empty($selectedStores)) {
                $completedQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $completedQuery->whereBetween('approval_date', [$startDate, $endDate]);
            }
            $completedCount = $completedQuery->count();
            $completedPercentage = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;

            // Initialize query for expired
            $expiredQuery = OrdHead::where('status', 'expired');
            if (!empty($selectedStores)) {
                $expiredQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $expiredQuery->whereBetween('approval_date', [$startDate, $endDate]);
            }
            $expiredCount = $expiredQuery->count();
            $expiredPercentage = $totalCount > 0 ? ($expiredCount / $totalCount) * 100 : 0;

            // Initialize query for rejected
            $rejectedQuery = OrdHead::where('status', 'reject');
            if (!empty($selectedStores)) {
                $rejectedQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $rejectedQuery->whereBetween('approval_date', [$startDate, $endDate]);
            }
            $rejectedCount = $rejectedQuery->count();
            $rejectedPercentage = $totalCount > 0 ? ($rejectedCount / $totalCount) * 100 : 0;

            // Initialize query for delivery
            $deliveryQuery = OrdHead::where('status', 'delivery');
            if (!empty($selectedStores)) {
                $deliveryQuery->whereIn('ship_to', $selectedStores);
            }
            if (!empty($startDate) && !empty($endDate)) {
                $deliveryQuery->whereBetween('approval_date', [$startDate, $endDate]);
            }
            $deliveryCount = $deliveryQuery->count();
            $deliveryPercentage = $totalCount > 0 ? ($deliveryCount / $totalCount) * 100 : 0;

            // Prepare the response data
            $data = [
                'progress' => $progressCount,
                'progressPercentage' => round($progressPercentage, 2),
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

    public function followUp(Request $request)
    {
        // Query to fetch data with optimized columns and conditions
        $query = OrdHead::select(
                    'order_no',
                    'approval_date',
                    'not_after_date',
                    'status'
                )
                ->whereNotIn('status', ['Completed','Incompleted','Reject','Expired']);

        // Use DataTables with server-side processing
        return DataTables::of($query)
            ->addColumn('days_since_approval', function($row) {
                // Calculate days since approval with fallback logic
                $daysAgo = 4; // Start with 4 days ago
                while ($daysAgo >= 0) {
                    $targetDate = now()->subDays($daysAgo)->toDateString();
                    if ($row->approval_date == $targetDate) {
                        return $daysAgo . ' hari yang lalu';
                    }
                    $daysAgo--; // Decrement to check for the previous day
                }
                return 'Lebih dari 4 hari yang lalu'; // Fallback if no match is found
            })
            ->addColumn('action', function($row) {
                // Add action column
                return '<a href="#" class="btn btn-sm btn-primary">View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
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
                if (!empty($selectedStores)) {
                    $query->whereIn('ordhead.ship_to', $selectedStores);
                } else {
                    // Optionally, you can add a condition to filter for a specific store if needed
                    $query->where('ordhead.ship_to', 40); // Replace 40 with the actual identifier for the store you want to fetch
                }

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

    public function getPOCountPerRegion(Request $request)
    {
        try {
            // Query to count POs per region and status
            $poCounts = DB::table('ordhead')
                ->join('store', 'ordhead.ship_to', '=', 'store.store')
                ->join('region','region.id','store.region')
                ->select(
                    'region.name as region', // Ambil kolom region
                    'ordhead.status', // Ambil kolom status
                    DB::raw('COUNT(ordhead.order_no) as total_count') // Hitung jumlah PO
                )
                ->groupBy('region.name', 'ordhead.status') // Group by region dan status
                ->get();
    
            // Format response
            $response = [];
            foreach ($poCounts as $item) {
                $region = $item->region;
                $status = $item->status;
                $totalCount = $item->total_count;
    
                // Jika region belum ada di response, tambahkan
                if (!isset($response[$region])) {
                    $response[$region] = [
                        'region' => $region,
                        'total_count' => 0,
                        'statuses' => []
                    ];
                }
    
                // Tambahkan status dan jumlah ke region
                $response[$region]['statuses'][$status] = $totalCount;
                $response[$region]['total_count'] += $totalCount;
            }
    
            // Hitung persentase per region
            $totalCountAllRegions = array_sum(array_column($response, 'total_count'));
            foreach ($response as &$regionData) {
                $regionData['percentage'] = $totalCountAllRegions > 0 
                    ? ($regionData['total_count'] / $totalCountAllRegions) * 100 
                    : 0;
            }
    
            // Return JSON response
            return response()->json(array_values($response));
        } catch (\Exception $e) {
            // Handle any errors that may occur
            return response()->json(['error' => 'An error occurred while fetching data: ' . $e->getMessage()], 500);
        }
    }
    




}
