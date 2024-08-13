<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\OrdHead;
use App\Models\RcvHead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderRepositoryImplement extends Eloquent implements OrderRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(OrdHead $model)
    {
        $this->model = $model;
    }
    public function countDataPo($filterDate, $filterSupplier)
    {
        // If filterDate is null or an empty string, set it to the current year and month
        if (is_null($filterDate) || $filterDate == "null" || empty($filterDate)) {
            $currentDate = Carbon::now();
            $filterYear = $currentDate->year;
            $filterMonth = $currentDate->month;
        } else {
            // Extract year and month from the provided filterDate
            $filterYear = Carbon::parse($filterDate)->year;
            $filterMonth = Carbon::parse($filterDate)->month;
        }

        // Calculate the start and end date of the given month
        $startDate = Carbon::create($filterYear, $filterMonth, 1)->startOfMonth()->toDateString();
        $endDate = Carbon::create($filterYear, $filterMonth, 1)->endOfMonth()->toDateString();

        // Debug: Log the dates being used

        // Assuming $supplierUser and $filterSupplier are defined in your context
        $supplierUser = auth()->user(); // Example, replace with your actual supplier user retrieval logic
        $filterSupplier = request()->input('filterSupplier'); // Example, replace with your actual filter supplier logic

        $dailyCountsQuery = OrdHead::with('suppliers')
            ->select([
                DB::raw('DATE(approval_date) as tanggal'),
                DB::raw('COUNT(DISTINCT ordhead.id) as jumlah'),
                DB::raw('SUM(ordsku.unit_cost * ordsku.qty_ordered + ordsku.vat_cost * ordsku.qty_ordered) as total_cost'),
            ])
            ->leftJoin('ordsku', 'ordhead.id', '=', 'ordsku.ordhead_id')
            ->whereBetween('approval_date', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->when(optional($supplierUser)->hasRole('supplier'), function ($query) use ($supplierUser) {
                $query->where('ordhead.supplier', $supplierUser->username);
            })
            ->when(!empty($filterSupplier), function ($query) use ($filterSupplier) {
                $query->whereIn('ordhead.supplier', (array) $filterSupplier);
            });

        // Debug: Get the raw SQL query
        $sql = $dailyCountsQuery->toSql();

        // Execute the query and get the results
        $dailyCounts = $dailyCountsQuery->get();

        // Debug: Log the results

        $totals = $dailyCounts->reduce(function ($carry, $item) {
            $carry['totalPo'] += $item->jumlah;
            $carry['totalCost'] += $item->total_cost;
            return $carry;
        }, ['totalPo' => 0, 'totalCost' => 0]);

        return [
            'totalPo' => $totals['totalPo'],
            'totalCost' => $totals['totalCost'],
            'month' => str_pad($filterMonth, 2, '0', STR_PAD_LEFT), // Ensure month is two digits
            'year' => (string)$filterYear, // Convert year to string
        ];
    }

    public function updateStatus()
    {
        $now = Carbon::now()->toDateString();

        DB::transaction(function() use ($now) {
            // Update 'Confirmed' status
            Ordhead::whereHas('rcvhead', function($query) {
                $query->whereNull('order_no');
            })
            ->where('estimated_delivery_date', '>', $now)
            ->update(['status' => 'Confirmed']);

            // Update 'Rejected' status
            Ordhead::whereDoesntHave('rcvhead')
                ->where('estimated_delivery_date', '<', $now)
                ->update(['status' => 'Rejected']);
        });
    }

    public function getDailyCounts($startDate, $endDate, $filterSupplier, $supplierUser)
    {
        // Use aggregate functions and efficient joins
        return DB::table('ordhead')
            ->select([
                DB::raw('DATE(approval_date) as tanggal'),
                DB::raw('COUNT(CASE WHEN status = "Reject" THEN 1 END) as reject_count'),
                DB::raw('COUNT(CASE WHEN status = "Expired" THEN 1 END) as expired_count'),
                DB::raw('COUNT(CASE WHEN status = "Completed" THEN 1 END) as completed_count'),
                DB::raw('COUNT(CASE WHEN status = "Progress" AND estimated_delivery_date IS NULL THEN 1 END) as in_progress_count'),
                DB::raw('COUNT(CASE WHEN status = "Confirmed" OR status = "printed" THEN 1 END) as confirmed_count'),

                DB::raw('SUM(total_cost) as total_cost')
            ])
            ->whereBetween('approval_date', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->when(optional($supplierUser)->hasRole('supplier'), function ($query) use ($supplierUser) {
                $query->where('supplier', $supplierUser->username);
            })
            ->when(!empty($filterSupplier), function ($query) use ($filterSupplier) {
                $query->whereIn('supplier', (array) $filterSupplier);
            })
            ->get();
    }




    public function datas($filterDate, $filterSupplier, $filterOrderNo)
    {
        // Default filter date to current date if null
        if ($filterDate === null) {
            $filterDate = date('Y-m');
        }

        // Extract the year and month from the filter date
        $filterYear = date('Y', strtotime($filterDate));
        $filterMonth = date('m', strtotime($filterDate));

        // Initialize the query builder
        $query = DB::table('ordhead') // Assuming the table name is 'ord_heads'
            ->leftJoin('suppliers', 'ordhead.supplier', '=', 'suppliers.supp_code') // Adjust join columns
            ->leftJoin('ordsku', 'ordhead.order_no', '=', 'ordsku.order_no') // Adjust join columns
            ->leftJoin('rcvhead', 'ordhead.order_no', '=', 'rcvhead.order_no') // Adjust join columns
            ->leftJoin('stores', 'ordhead.ship_to', '=', 'stores.store') // Adjust join columns
            ->select([
                'ordhead.*', // Select all columns from ord_heads
                'suppliers.supp_code', 'suppliers.name',
                'ordsku.product_id', 'ordsku.quantity',
                'rcvhead.received_date',
                'stores.store', 'stores.name',
            ])
            ->orderBy('ordhead.id', 'desc');

        // Apply filters if provided
        if ($filterSupplier !== null) {
            $query->where('ordhead.supplier', $filterSupplier);
        }

        if ($filterOrderNo !== null) {
            $query->where('ordhead.order_no', $filterOrderNo);
        }

        // Optionally filter by date if needed
        if ($filterDate !== null) {
            $query->whereYear('ordhead.created_at', $filterYear)
                  ->whereMonth('ordhead.created_at', $filterMonth);
        }

        // Execute the query and get the results
        $results = $query->get(); // This returns a Collection

        // Check if results are empty or not
        if ($results->isEmpty()) {
            // Debugging: Log or print a message if no results are found
            // dd('No results found.');
        }

        // Safely handle results
        $itemCount = $results->count(); // Collection method
        // Return item count and results
        return $results;
    }


    public function getOrderData($filterYear, $filterMonth)
    {
        return $this->model
            ->select([
                'ordhead.id',
                'ordhead.order_no',
                'supplier.supp_code',
                'supplier.supp_name',
                'store.store',
                'store.store_name',
                'ordhead.approval_date',
                'ordhead.status',
                'rcvhead.receive_no',
                'ordhead.estimated_delivery_date',
                'ordhead.not_after_date',
                'rcvhead.receive_date',
                'rcvhead.average_service_level',
                DB::raw('SUM(ordsku.qty_ordered) as qty_ordered'),
                DB::raw('MAX(rcvhead.receive_date) as last_receive_date'),
                DB::raw('COUNT(CASE WHEN ordhead.status = "confirmed" THEN 1 END) as confirmed_count')
            ])
            ->leftJoin('supplier', 'ordhead.supplier', '=', 'supplier.supp_code')
            ->leftJoin('ordsku', 'ordhead.order_no', '=', 'ordsku.order_no')
            ->leftJoin('rcvhead', 'ordhead.order_no', '=', 'rcvhead.order_no')
            ->leftJoin('store', 'ordhead.ship_to', '=', 'store.store')
            ->groupBy([
                'ordhead.order_no',
                'ordhead.id',
                'rcvhead.receive_no',
                'supplier.supp_code',
                'supplier.supp_name',
                'store.store',
                'store.store_name',
                'ordhead.approval_date',
                'ordhead.status',
                'ordhead.not_after_date',
                'rcvhead.receive_date',
                'rcvhead.average_service_level',
                'ordhead.estimated_delivery_date',
            ])
            ->whereYear('ordhead.approval_date', $filterYear)
            ->whereMonth('ordhead.approval_date', $filterMonth)
            ->orderBy(DB::raw('MAX(ordhead.approval_date)'), 'desc');  // Use an aggregate function for ordering
    }







    // Write something awesome :)
}
