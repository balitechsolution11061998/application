<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Repository;

interface OrderRepository extends Repository{

    // Write something awesome :)
    public function countDataPo($filterDate, $filterSupplier);
    public function getDailyCounts($startDate,$endDate,$filterSupplier,$user);
    public function datas($filterDate, $filterSupplier,$filterOrderNo);
    public function updateStatus();
    public function getOrderData($filterYear, $filterMonth);
}
