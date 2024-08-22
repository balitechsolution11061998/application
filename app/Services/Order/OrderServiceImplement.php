<?php

namespace App\Services\Order;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Order\OrderRepository;
use App\Services\PerformanceLogger\PerformanceLoggerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
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
     protected $performanceLogger;

    public function __construct(OrderRepository $mainRepository,PerformanceLoggerService $performanceLogger)
    {
      $this->mainRepository = $mainRepository;
      $this->performanceLogger = $performanceLogger;
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
        while ($currentDate->month === $filterMonth && $currentDate->year === $filterYear) {
            $allDates[$currentDate->toDateString()] = [
                'reject_count' => 0,
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
            if (isset($allDates[$date])) {
                $allDates[$date] = [
                    'reject_count' => $item->reject_count ?? 0,
                    'expired_count' => $item->expired_count,
                    'completed_count' => $item->completed_count,
                    'confirmed_count' => $item->confirmed_count,
                    'in_progress_count' => $item->in_progress_count,
                    'confirmed_mismatch_count' => $item->confirmed_mismatch_count ?? 0,
                    'total_cost' => $item->total_cost,
                ];
            }
        }

        $totals = array_reduce($allDates, function ($carry, $item) {
            $carry['totalPo'] += $item['reject_count'] + $item['expired_count'] + $item['completed_count'] + $item['confirmed_count'] + $item['in_progress_count'];
            $carry['reject'] += $item['reject_count'];
            $carry['expired'] += $item['expired_count'];
            $carry['completed'] += $item['completed_count'];
            $carry['confirmed'] += $item['confirmed_count'];
            $carry['in_progress'] += $item['in_progress_count'];
            $carry['confirmed_mismatch'] += $item['confirmed_mismatch_count'];
            $carry['totalCost'] += $item['total_cost'];
            return $carry;
        }, [
            'totalPo' => 0,
            'reject' => 0,
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
                'reject' => $item['reject_count'],
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
            'reject' => $totals['reject'],
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


    public function datas($filterDate,$filterSupplier,$filterOrderNo){
        try {
            return $this->mainRepository->datas($filterDate, $filterSupplier,$filterOrderNo);
        } catch (Exception $exception) {
            Log::error($exception);
            return null;
        }
    }


    public function getOrderData($filterDate = null, $filterSupplier = null, $filterOrderNo = null, $filterStatus = null)
    {
        // Membuat key untuk cache berdasarkan filter
        $cacheKey = 'order_data_' . md5($filterDate . $filterSupplier . $filterOrderNo . $filterStatus);

        // Cek apakah hasil query sudah ada di cache
        return Cache::remember($cacheKey, 10, function () use ($filterDate, $filterSupplier, $filterOrderNo, $filterStatus) {
            $query = $this->mainRepository->getOrderData($filterDate, $filterSupplier, $filterOrderNo, $filterStatus);

            $dataCollection = collect();

            // Process data in chunks to reduce memory usage
            $query->chunk(1000, function($rows) use ($dataCollection) {
                foreach ($rows as $row) {
                    $dataCollection->push($row);
                }
            });

            return $dataCollection;
        });
    }




    public function logPerformanceData($data, $executionTime, $memoryUsage)
    {
        $this->performanceLogger->logPerformanceData($data, $executionTime, $memoryUsage);
    }
}
