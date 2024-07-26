<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\OrdHead;
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


    public function countDataPoPerDays($filterDate, $filterSupplier)
    {
        // If filterDate is null, set it to the current date
        if ($filterDate == "null") {

            $currentDate = Carbon::now();
            $filterYear = $currentDate->year;
            $filterMonth = $currentDate->month;
        } else {
            // Extract year and month from the provided filterDate
            $filterYear = date('Y', strtotime($filterDate));
            $filterMonth = date('m', strtotime($filterDate));
        }

        $dailyCountsQuery = OrdHead::with('suppliers')
            ->select([
                DB::raw('DATE(approval_date) as tanggal'),
                DB::raw('COUNT(DISTINCT ordhead.id) as jumlah'),
                DB::raw('SUM(ordsku.unit_cost * ordsku.qty_ordered + ordsku.vat_cost * ordsku.qty_ordered) as total_cost'),
            ])
            ->leftJoin('ordsku', 'ordhead.id', '=', 'ordsku.ordhead_id')
            ->whereYear('approval_date', $filterYear)
            ->whereMonth('approval_date', $filterMonth)
            ->groupBy('tanggal');

        // Optionally filter by supplier if provided
        // if (!empty($filterSupplier)) {
        //     $dailyCountsQuery->whereIn('ordhead.supplier', (array) $filterSupplier);
        // }

        $dailyCounts = $dailyCountsQuery->get();

        // Create an associative array to store totalPo and totalCost per tanggal

        // Iterate through dailyCounts and populate dataPerTanggal array
        $dataPerTanggal = [];

        foreach ($dailyCounts as $dailyCount) {
            $dataPerTanggal[] = (object)[
                'tanggal' => $dailyCount->tanggal,
                'totalPo' => $dailyCount->jumlah,
                'totalCost' => $dailyCount->total_cost,
            ];
        }

        return $dataPerTanggal;
    }

    public function data($filterDate, $filterSupplier)
    {
        // If filterDate is null, set it to the current date
        if ($filterDate == "null") {
            $filterDate = date('Y-m');
            $filterYear = date('Y', strtotime($filterDate));
            $filterMonth = date('m', strtotime($filterDate));
        } else {
            $filterYear = date('Y', strtotime($filterDate));
            $filterMonth = date('m', strtotime($filterDate));
        }

        // Initialize query with eager loading and specify columns to select
        $query = OrdHead::query()
            ->with([
                'suppliers:supp_code,supp_name,address_1',
                'ordDetail',
                'rcvHead:receive_no',
                'stores',

            ])
            ->orderBy('id', 'desc')
            ->limit(20);
        // Filter based on supplier if provided
        if (!empty($filterSupplier)) {
            $query->whereIn('supplier_id', $filterSupplier);
        }


        // Initialize an empty collection to store the results
        // $dailyCounts = collect([]);

        // // Chunk the data to process in smaller batches
        // $query->chunk(2000, function ($orders) use ($dailyCounts) {
        //     foreach ($orders as $order) {
        //         // Convert the order to an array to reduce memory usage
        //         $dailyCounts->push($order->toArray());
        //     }
        //     // Release memory after processing each chunk
        //     unset($orders);
        // });

        // Flatten the collection to get a single collection of orders
        // $dailyCounts = $dailyCounts->get();
        $dailyCounts = $query->get();
        return $dailyCounts;
    }




    // Write something awesome :)
}
