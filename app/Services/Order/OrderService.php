<?php

namespace App\Services\Order;

use LaravelEasyRepository\BaseService;

interface OrderService extends BaseService{
    public function countDataPo($filterDate, $filterSupplier);
    public function countDataPoPerDays($filterDate, $filterSupplier);
    public function datas($filterDate, $filterSupplier,$filterOrderNo);
    public function getOrderData($filterDate, $filterSupplier, $filterOrderNo);
    public function logPerformanceData($data, $executionTime, $memoryUsage);
}
