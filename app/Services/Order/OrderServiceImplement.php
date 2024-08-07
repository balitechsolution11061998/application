<?php

namespace App\Services\Order;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Order\OrderRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderServiceImplement extends ServiceApi implements OrderService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(OrderRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function countDataPo($filterDate, $filterSupplier)
    {
        try {
            return $this->mainRepository->countDataPo($filterDate, $filterSupplier);
        } catch (Exception $exception) {
            Log::error($exception);
            return null;
        }
    }



    public function countDataPoPerDays($filterDate, $filterSupplier)
    {
        $this->mainRepository->updateStatus();

        $filterData = $this->processFilters($filterDate);
        $allDates = $this->initializeDateRange($filterData['filterYear'], $filterData['filterMonth']);

        $dailyCounts = $this->mainRepository->getDailyCounts(
            $filterData['startDate'],
            $filterData['endDate'],
            $filterSupplier,
            auth()->user()
        );

        return $this->formatData($dailyCounts, $allDates, $filterData['filterYear'], $filterData['filterMonth']);
    }

    protected function processFilters($filterDate)
    {
        if (is_null($filterDate) || $filterDate == "null" || empty($filterDate)) {
            $currentDate = Carbon::now();
            $filterYear = $currentDate->year;
            $filterMonth = $currentDate->month;
        } else {
            $filterYear = Carbon::parse($filterDate)->year;
            $filterMonth = Carbon::parse($filterDate)->month;
        }

        return [
            'filterYear' => $filterYear,
            'filterMonth' => $filterMonth,
            'startDate' => Carbon::create($filterYear, $filterMonth, 1)->startOfMonth()->toDateString(),
            'endDate' => Carbon::create($filterYear, $filterMonth, 1)->endOfMonth()->toDateString()
        ];
    }

    protected function initializeDateRange($filterYear, $filterMonth)
    {
        $allDates = [];
        $currentDate = Carbon::create($filterYear, $filterMonth, 1);
        while ($currentDate->format('Y-m') === $filterYear . '-' . str_pad($filterMonth, 2, '0', STR_PAD_LEFT)) {
            $allDates[$currentDate->toDateString()] = [
                'expired_count' => 0,
                'completed_count' => 0,
                'confirmed_count' => 0,
                'in_progress_count' => 0,
                'confirmed_mismatch_count' => 0,
                'total_cost' => 0.0,
            ];
            $currentDate->addDay();
        }
        return $allDates;
    }

    protected function formatData($dailyCounts, $allDates, $filterYear, $filterMonth)
    {
        foreach ($dailyCounts as $item) {
            $date = $item->tanggal;
            $allDates[$date] = [
                'expired_count' => $item->expired_count,
                'completed_count' => $item->completed_count,
                'confirmed_count' => $item->confirmed_count,
                'in_progress_count' => $item->in_progress_count,
                'confirmed_mismatch_count' => 0,
                'total_cost' => $item->total_cost,
            ];
        }

        $totals = array_reduce($allDates, function ($carry, $item) {
            $carry['totalPo'] += $item['expired_count'] + $item['completed_count'] + $item['confirmed_count'] + $item['in_progress_count'];
            $carry['expired'] += $item['expired_count'];
            $carry['completed'] += $item['completed_count'];
            $carry['confirmed'] += $item['confirmed_count'];
            $carry['in_progress'] += $item['in_progress_count'];
            $carry['confirmed_mismatch'] += $item['confirmed_mismatch_count'];
            $carry['totalCost'] += $item['total_cost'];
            return $carry;
        }, [
            'totalPo' => 0,
            'expired' => 0,
            'completed' => 0,
            'confirmed' => 0,
            'in_progress' => 0,
            'confirmed_mismatch' => 0,
            'totalCost' => 0.0,
        ]);

        $dailyData = array_map(function ($item, $date) {
            return [
                'date' => $date,
                'expired' => $item['expired_count'],
                'completed' => $item['completed_count'],
                'confirmed' => $item['confirmed_count'],
                'in_progress' => $item['in_progress_count'],
                'confirmed_mismatch' => $item['confirmed_mismatch_count'],
                'total_cost' => $item['total_cost'],
            ];
        }, $allDates, array_keys($allDates));

        return [
            'totalPo' => $totals['totalPo'],
            'expired' => $totals['expired'],
            'completed' => $totals['completed'],
            'confirmed' => $totals['confirmed'],
            'in_progress' => $totals['in_progress'],
            'confirmedMismatch' => $totals['confirmed_mismatch'],
            'totalCost' => $totals['totalCost'],
            'month' => str_pad($filterMonth, 2, '0', STR_PAD_LEFT),
            'year' => (string)$filterYear,
            'dailyData' => $dailyData,
        ];
    }

    public function data($filterDate,$filterSupplier,$filterStatus){
        try {
            return $this->mainRepository->data($filterDate, $filterSupplier,$filterStatus);
        } catch (Exception $exception) {
            Log::error($exception);
            return null;
        }
    }

    // Define your custom methods :)
}
