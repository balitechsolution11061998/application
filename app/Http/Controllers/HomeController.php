<?php

namespace App\Http\Controllers;

use App\Helpers\PerformanceHelper;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\OrdHead;
use App\Models\PaketSoal;
use App\Models\Pengumuman;
use App\Models\PerformanceAnalysis;
use App\Models\QueryPerformanceLog;
use App\Models\RcvHead;
use App\Models\Siswa;
use App\Models\User;
use App\Services\Order\OrderService;
use App\Services\Rcv\RcvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Binafy\LaravelUserMonitoring\Traits\Actionable;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    //
    use Actionable;

    protected $orderService;
    protected $rcvService;

    public function __construct(
        OrderService $orderService,
        RcvService $rcvService,
    ) {

        $this->orderService = $orderService;
        $this->rcvService = $rcvService;
        $this->middleware('auth');

    }
    public function index()
    {
        if (!Auth::check()) {
            // If the user is not authenticated, redirect to a login page
            return redirect()->route('login');
        }

        $user = Auth::user();
        $id = $user->id;
        $messengerColor = '#ff0000'; // Example color; replace with actual value
        $dark_mode = 'dark'; // or 'light'

        if ($user->hasRole('superadministrator')) {
            return view('home', compact('id', 'messengerColor', 'dark_mode'));
        }

        if ($user->hasRole('admin_karyawan') || $user->hasRole('karyawan')) {
            return view('home3', compact('id', 'messengerColor', 'dark_mode'));
        }

        if ($user->hasRole('admin_cbt') || $user->hasRole('siswa') || $user->hasRole('guru')) {
            $dashboardData = $this->getDashboardData();
            return view('home2', $dashboardData);
        }

        // Handle cases where the user role does not match any predefined roles
        return view('website', compact('id', 'messengerColor', 'dark_mode'));
    }

    public function index2()
    {
        // Use the shared dashboard data method for consistency
        $dashboardData = $this->getDashboardData();
        return view('home2', $dashboardData);
    }

    public function index3()
    {
        return view('home3');
    }

    public function index4()
    {
        return view('home4');
    }

    /**
     * Get shared dashboard data with caching.
     *
     * @return array
     */
    private function getDashboardData()
    {
        // Cache the dashboard data for 60 minutes
        $cacheKey = 'dashboardData';
        $cacheDuration = 20; // Cache duration in minutes

        return Cache::remember($cacheKey, $cacheDuration, function () {
            $jadwal = Jadwal::count();
            $guru = Guru::count();
            $gurulk = Guru::where('jk', 'L')->count();
            $gurupr = Guru::where('jk', 'P')->count();
            $siswa = Siswa::count();
            $siswalk = Siswa::where('jk', 'L')->count();
            $siswapr = Siswa::where('jk', 'P')->count();
            $kelas = Kelas::count();
            $bkp = Kelas::where('paket_id', 1)->count();
            $dpib = Kelas::where('paket_id', 2)->count();
            $ei = Kelas::where('paket_id', 3)->count();
            $oi = Kelas::where('paket_id', 4)->count();
            $tbsm = Kelas::where('paket_id', 6)->count();
            $rpl = Kelas::where('paket_id', 7)->count();
            $tpm = Kelas::where('paket_id', 5)->count();
            $las = Kelas::where('paket_id', 8)->count();
            $mapel = MataPelajaran::count();
            $user = User::count();
            $paket = PaketSoal::all();

            $hari = date('w');
            $jam = date('H:i');
            $jadwalGuru = Jadwal::orderBy('jam_mulai')
                ->orderBy('jam_selesai')
                ->orderBy('kelas_id')
                ->where('hari_id', $hari)
                ->where('jam_mulai', '<=', $jam)
                ->where('jam_selesai', '>=', $jam)
                ->get();

            $pengumuman = Pengumuman::first();
            $kehadiran = Kehadiran::all();

            return compact(
                'jadwal',
                'guru',
                'gurulk',
                'gurupr',
                'siswalk',
                'siswapr',
                'siswa',
                'kelas',
                'bkp',
                'dpib',
                'ei',
                'oi',
                'tbsm',
                'rpl',
                'tpm',
                'las',
                'mapel',
                'user',
                'paket',
                'jadwalGuru',
                'pengumuman',
                'kehadiran'
            );
        });
    }
    public function dashboarduser(){
        $hari = date('w');
        $jam = date('H:i');
        $jadwal = Jadwal::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('kelas_id')->where('hari_id', $hari)->where('jam_mulai', '<=', $jam)->where('jam_selesai', '>=', $jam)->get();
        $pengumuman = Pengumuman::first();
        $kehadiran = Kehadiran::all();
        return view('home5', compact('jadwal', 'pengumuman', 'kehadiran'));
    }

    public function countDataPoPerDays(Request $request)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            // Capture filters from the request
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;

            // Define a cache key based on the filters
            $cacheKey = "countDataPoPerDays_{$filterDate}_{$filterSupplier}";
            $cacheDuration = 20; // Cache duration in minutes

            // Check if the data is already cached
            $data = Cache::remember($cacheKey, $cacheDuration, function () use ($filterDate, $filterSupplier) {
                // Perform status updates
                DB::table('ordhead')
                    ->join('rcvhead', 'rcvhead.order_no', '=', 'ordhead.order_no')
                    ->whereNotNull('ordhead.estimated_delivery_date')
                    ->whereNull('rcvhead.receive_no')
                    ->where('ordhead.not_after_date', '>', now())
                    ->whereNotIn('ordhead.status', ['Confirmed', 'Progress'])
                    ->update(['ordhead.status' => 'Confirmed']);

                DB::table('ordhead')
                    ->join('rcvhead', 'rcvhead.order_no', '=', 'ordhead.order_no')
                    ->whereNotNull('ordhead.estimated_delivery_date')
                    ->whereNull('rcvhead.receive_no')
                    ->where('ordhead.not_after_date', '<', now())
                    ->whereNotIn('ordhead.status', ['Confirmed', 'Progress'])
                    ->update(['ordhead.status' => 'Expired']);

                // Fetch data from the service
                return $this->orderService->countDataPoPerDays($filterDate, $filterSupplier);
            });

            // Example: Assume $data is an array or collection
            $totalCount = count($data);
            $processedCount = $totalCount; // Assuming all records are processed, adjust if necessary

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Determine performance status based on execution time
            $status = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

            // Create or update performance analysis record
            $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
                'total_count' => $totalCount,
                'processed_count' => $processedCount,
                'success_count' => $processedCount, // Assuming all processed are successful, adjust if necessary
                'fail_count' => 0, // Adjust if you have failure cases
                'errors' => null,
                'execution_time' => $executionTime,
                'status' => $status
            ]);

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Count Data PO Per Days',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id
            ]);

            // Return the data as a JSON response
            return response()->json([
                'success' => true,
                'data' => $data,
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);
        } catch (\Throwable $th) {
            // Handle exceptions and return a JSON response
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }


    public function countDataPoPerDate(Request $request)
    {
        $date = $request->query('date'); // Get the date parameter from the request
        $status = $request->query('status'); // Get the status parameter from the request

        try {
            $startTime = microtime(true); // Start timing

            // Define a cache key based on the date and status
            $cacheKey = "countDataPoPerDate_{$date}_{$status}";
            $cacheDuration = 20; // Cache duration in minutes

            // Check if the data is already cached
            $data = Cache::remember($cacheKey, $cacheDuration, function () use ($date, $status) {
                // Fetch and process data for the specified date and status
                $query = OrdHead::with('rcvHead')->whereDate('approval_date', $date);

                if ($status) {
                    if ($status === 'In Progress') {
                        $status = 'progress';
                        $query->where(function ($q) {
                            $q->whereNull('estimated_delivery_date')
                              ->where('status', 'progress');
                        });
                    } else if ($status === 'Confirmed') {
                        $query->whereIn('status', ['Confirmed', 'printed']);
                    } else {
                        $query->where('status', $status);
                    }
                }

                // Fetch the data
                $data = $query->get();
                $processedCount = 0; // To track how many records are processed

                foreach ($data as $record) {
                    $existsInReceiving = RcvHead::where('order_no', $record->order_no)->exists();

                    if ($existsInReceiving) {
                        $record->status = 'Completed';
                    } elseif ($record->estimated_delivery_date !== null) {
                        $record->status = 'Confirmed';
                    } elseif (!$existsInReceiving && $record->not_after_date && Carbon::parse($record->not_after_date)->isPast()) {
                        $record->status = 'Expired';
                    }

                    $record->save();
                    $processedCount++; // Increment processed count
                }

                return $data;
            });

            $endTime = microtime(true); // End timing
            $executionTime = $endTime - $startTime; // Calculate execution time
            $memoryUsage = memory_get_usage(); // Get memory usage

            $status = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

            // Create or update performance analysis record
            $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
                'total_count' => $data->count(),
                'processed_count' => $processedCount,
                'success_count' => $processedCount, // Assuming all processed are successful, adjust if necessary
                'fail_count' => 0, // Adjust if you have failure cases
                'errors' => null,
                'execution_time' => $executionTime,
                'status' => $status
            ]);

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Count Data PO Per Date',
                'parameters' => json_encode(['date' => $date, 'status' => $status]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id
            ]);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function serviceLevel(Request $request)
    {
        $date = $request->query('date'); // Get the date parameter from the request

        // Generate a unique cache key based on the date
        $cacheKey = 'serviceLevel_' . ($date ? $date : 'all');

        // Attempt to retrieve cached data
        $cachedResults = Cache::remember($cacheKey, 20, function () use ($date) {
            $startTime = microtime(true); // Start timing

            // Fetch data for each supplier from rcvhead table
            $results = RcvHead::select('supplier', 'sup_name', 'average_service_level')
                ->when($date, function ($query, $date) {
                    return $query->whereDate('created_at', $date); // Filter by date if provided
                })
                ->get()
                ->groupBy('supplier')
                ->map(function ($items) {
                    $averageServiceLevel = $items->avg('average_service_level');
                    $supplier = $items->first(); // Get the first item to access related data

                    return [
                        'supplier_id' => $supplier->supplier,
                        'supplier_name' => $supplier->sup_name,
                        'average_service_level' => round($averageServiceLevel, 2) // Round to 2 decimal places
                    ];
                })
                ->sortByDesc('average_service_level') // Sort by average_service_level in descending order
                ->take(5) // Take the top 5 results
                ->values()
                ->all();

            $endTime = microtime(true); // End timing
            $executionTime = $endTime - $startTime; // Calculate execution time
            $memoryUsage = memory_get_usage(); // Get memory usage

            // Determine performance status based on execution time
            $performanceStatus = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

            // Create or update performance analysis record
            $performanceAnalysis = PerformanceAnalysis::create([
                'total_count' => count($results),
                'processed_count' => count($results),
                'success_count' => count($results), // Assuming all processed are successful
                'fail_count' => 0,
                'errors' => null,
                'execution_time' => $executionTime,
                'status' => $performanceStatus
            ]);

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Calculate Average Service Level',
                'parameters' => json_encode(['date' => $date]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id
            ]);

            return $results;
        });

        return response()->json([
            'success' => true,
            'data' => $cachedResults
        ]);
    }


    public function priceDiff(Request $request)
    {
        $date = $request->query('date'); // Get the date parameter from the request

        // Generate a unique cache key based on the date
        $cacheKey = 'priceDiff_' . ($date ? $date : 'all');

        try {
            // Attempt to retrieve cached data
            $cachedData = Cache::remember($cacheKey, 20, function () use ($date) {
                $query = DB::table('diff_cost_po')
                    ->select('supplier', 'sup_name', 'sku', 'sku_desc', 'cost_po', 'cost_supplier')
                    ->when($date, function ($query, $date) {
                        return $query->whereDate('created_at', $date); // Filter by date if provided
                    });

                // Fetch data and process it
                $data = $query->get()
                    ->map(function ($item) {
                        return [
                            'supplier_id' => $item->supplier,
                            'supplier_name' => $item->sup_name,
                            'sku' => $item->sku,
                            'sku_desc' => $item->sku_desc,
                            'cost_po' => $item->cost_po,
                            'cost_supplier' => $item->cost_supplier,
                            'price_difference' => $item->cost_supplier ? $item->cost_supplier - $item->cost_po : null // Calculate price difference
                        ];
                    })
                    ->sortByDesc('price_difference');

                return $data;
            });

            // Create a DataTable instance
            return DataTables::of($cachedData)
                ->addColumn('formatted_cost_po', function ($item) {
                    return number_format($item['cost_po'], 0, ',', '.'); // Format cost_po
                })
                ->addColumn('formatted_cost_supplier', function ($item) {
                    return number_format($item['cost_supplier'], 0, ',', '.'); // Format cost_supplier
                })
                ->editColumn('price_difference', function ($item) {
                    return number_format($item['price_difference'], 0, ',', '.'); // Format price difference
                })
                ->make(true);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // In your Controller
    public function getTotals()
    {
        // Generate a unique cache key
        $cacheKey = 'totals';

        try {
            // Attempt to retrieve cached data
            $cachedData = Cache::remember($cacheKey, 20, function () {
                // Fetch total suppliers and stores
                $totalSuppliers = DB::table('supplier')->count(); // Adjust table name
                $totalStores = DB::table('store')->count(); // Adjust table name

                return [
                    'totalSuppliers' => $totalSuppliers,
                    'totalStores' => $totalStores
                ];
            });

            return response()->json([
                'success' => true,
                'totalSuppliers' => $cachedData['totalSuppliers'],
                'totalStores' => $cachedData['totalStores']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function tandaTerima(Request $request)
    {
        $date = $request->query('date'); // Get the date parameter from the request

        // Generate a unique cache key based on the date
        $cacheKey = 'tandaTerima_' . ($date ? $date : 'all');

        // Attempt to retrieve cached data
        $cachedQuery = Cache::remember($cacheKey, 20, function () use ($date) {
            // Fetch data from tandaterima_head table where status is 'pending'
            return DB::table('tandaterima_head')
                ->where('status', 'pending') // Ensure that only records with status 'pending' are fetched
                ->when($date, function ($query, $date) {
                    return $query->whereDate('tanggal', $date);
                })
                ->orderBy('tanggal', 'desc') // Order by date descending to get the latest records
                ->limit(4) // Limit to 4 records
                ->get();
        });

        // Return DataTables instance
        return DataTables::of($cachedQuery)
            ->addColumn('action', function ($item) {
                // Define any actions or buttons here if needed
                return '<a href="#" class="btn btn-info btn-sm">View</a>';
            })
            ->editColumn('status', function ($item) {
                // Customize the status display
                return $item->status === 'n'
                    ? '<span class="badge bg-danger">Not Received</span>'
                    : '<span class="badge bg-success">Received</span>';
            })
            ->rawColumns(['status', 'action']) // Allow HTML in columns
            ->make(true);
    }



    public function countTandaTerimaCurrentMonthYear()
    {
        // Get the current month and year in 'Y-m' format
        $currentMonthYear = date('Y-m');

        // Generate a unique cache key based on the current month and year
        $cacheKey = 'countTandaTerima_' . $currentMonthYear;

        // Attempt to retrieve cached data
        $cachedResult = Cache::remember($cacheKey, 20, function () use ($currentMonthYear) {
            // Query to count records and sum quantity for the entire current month and year
            $result = DB::table('tandaterima_head as th')
                ->leftJoin('tandaterima_detail as td', 'th.id', '=', 'td.tthead_id') // Left join with tandaterima_detail
                ->select(
                    DB::raw('COUNT(DISTINCT th.no_tt) as total_count'),   // Count of unique no_tt in tandaterima_head
                    DB::raw('COALESCE(SUM(td.jumlah), 0) as total_quantity') // Sum of quantity from tandaterima_detail, defaulting to 0 if null
                )
                ->where('th.tanggal', 'like', $currentMonthYear . '%') // Match records with the current year-month
                ->first(); // Get the first result

            // Handle the case where no records are found
            $totalCount = $result ? $result->total_count : 0;
            $totalQuantity = $result ? $result->total_quantity : 0;

            return [
                'totalTandaTerima' => $totalCount,
                'totalCostTandaTerima' => $totalQuantity
            ];
        });

        // Return the result as a JSON response
        return response()->json($cachedResult);
    }






    public function countDataPo(Request $request)
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;

            // Generate a unique cache key based on filters
            $cacheKey = 'countDataPo_' . md5($filterDate . $filterSupplier);

            // Attempt to retrieve cached data
            $cachedTotal = Cache::remember($cacheKey, 20, function () use ($filterDate, $filterSupplier) {
                // Fetch the total count of data
                return $this->orderService->countDataPo($filterDate, $filterSupplier);
            });

            // Calculate execution time and memory usage
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Determine performance status based on execution time
            $status = $executionTime > 1 ? 'slow' : 'fast'; // Example threshold of 1 second

            // Create or update performance analysis record
            $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
                'total_count' => $cachedTotal, // Assuming 'cachedTotal' represents total_count
                'processed_count' => $cachedTotal, // Assuming all data counted are processed
                'success_count' => $cachedTotal, // Assuming all processed are successful
                'fail_count' => 0, // Adjust if you have failure cases
                'errors' => null,
                'execution_time' => $executionTime,
                'status' => $status
            ]);

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'Count Data Purchase Order',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id // Ensure this ID is provided
            ]);

            return response()->json([
                'success' => true,
                'total' => $cachedTotal,
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);
        } catch (\Throwable $th) {
            // Log the exception for debugging
            \Log::error('Failed to count data PO: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function countDataRcv(Request $request) {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->input('filterDate');
            $filterSupplier = $request->input('filterSupplier');

            $currentDate = Carbon::now();
            $filterYear = $filterDate ? Carbon::parse($filterDate)->year : $currentDate->year;
            $filterMonth = $filterDate ? Carbon::parse($filterDate)->month : $currentDate->month;

            $startDate = Carbon::create($filterYear, $filterMonth, 1)->startOfMonth()->toDateString();
            $endDate = Carbon::create($filterYear, $filterMonth, 1)->endOfMonth()->toDateString();

            // Generate a cache key
            $cacheKey = "countDataRcv_{$filterYear}_{$filterMonth}_" . md5($filterSupplier);

            // Retrieve cached data or compute it
            $cachedData = Cache::remember($cacheKey, 10, function () use ($startDate, $endDate, $filterYear, $filterMonth, $filterSupplier) {
                $totals = DB::table('rcvhead')
                    ->selectRaw('COUNT(DISTINCT rcvhead.id) as totalRcv, SUM(rcvdetail.unit_cost * rcvdetail.qty_received + rcvdetail.vat_cost * rcvdetail.qty_received) as totalCostRcv')
                    ->leftJoin('ordhead', 'ordhead.order_no', '=', 'rcvhead.order_no')
                    ->join('rcvdetail', 'rcvhead.id', '=', 'rcvdetail.rcvhead_id')
                    ->whereBetween('receive_date', [$startDate, $endDate])
                    ->whereYear('ordhead.approval_date', $filterYear)
                    ->whereMonth('ordhead.approval_date', $filterMonth)
                    ->when(Auth::user()->hasRole('supplier'), function ($query) {
                        $query->where('rcvhead.supplier', Auth::user()->username);
                    })
                    ->when(!empty($filterSupplier), function ($query) use ($filterSupplier) {
                        $query->whereIn('rcvhead.supplier', (array) $filterSupplier);
                    })
                    ->first();

                $totalCount = DB::table('rcvhead')->whereBetween('receive_date', [$startDate, $endDate])->count();
                $processedCount = $totalCount;
                $successCount = $processedCount;
                $failCount = 0;

                return [
                    'totalRcv' => $totals->totalRcv ?? 0,
                    'totalCostRcv' => $totals->totalCostRcv ?? 0,
                    'month' => str_pad($filterMonth, 2, '0', STR_PAD_LEFT),
                    'year' => (string)$filterYear,
                    'total_count' => $totalCount,
                    'processed_count' => $processedCount,
                    'success_count' => $successCount,
                    'fail_count' => $failCount
                ];
            });

            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Log performance metrics
            $performanceAnalysis = \App\Models\PerformanceAnalysis::create([
                'total_count' => $cachedData['total_count'],
                'processed_count' => $cachedData['processed_count'],
                'success_count' => $cachedData['success_count'],
                'fail_count' => $cachedData['fail_count'],
                'errors' => null,
                'execution_time' => $executionTime,
                'status' => $executionTime > 1 ? 'slow' : 'fast'
            ]);

            QueryPerformanceLog::create([
                'function_name' => 'Count Data RCV',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage,
                'performance_analysis_id' => $performanceAnalysis->id
            ]);

            return response()->json($cachedData);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }



    public function countDataRcvPerDays(Request $request) {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            $filterDate = $request->filterDate;
            $filterSupplier = $request->filterSupplier;

            // Generate a unique cache key based on filters
            $cacheKey = 'countDataRcvPerDays_' . md5($filterDate . $filterSupplier);

            // Attempt to retrieve cached data
            $cachedTotal = Cache::remember($cacheKey, 20, function () use ($filterDate, $filterSupplier) {
                return $this->rcvService->countDataRcvPerDays($filterDate, $filterSupplier);
            });

            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_usage() - $startMemory;

            // Log performance metrics
            QueryPerformanceLog::create([
                'function_name' => 'countDataRcvPerDays',
                'parameters' => json_encode(['filterDate' => $filterDate, 'filterSupplier' => $filterSupplier]),
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);

            return response()->json([
                'success' => true,
                'total' => $cachedTotal,
                'execution_time' => $executionTime,
                'memory_usage' => $memoryUsage
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }


}
