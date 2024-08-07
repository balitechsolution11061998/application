<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Repository;

interface OrderRepository extends Repository{

    // Write something awesome :)
    public function countDataPo($filterDate, $filterSupplier);
    public function getDailyCounts($startDate,$endDate,$filterSupplier,$user);
    public function data($filterDate, $filterSupplier,$filterStatus);
    public function updateStatus();

}
