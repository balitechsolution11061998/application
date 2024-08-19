<?php

namespace Database\Seeders;

use App\Jobs\InsertOrderData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdheadAndOrdskuSeeder extends Seeder
{
    public function run()
    {
        $totalRecords = 1000;
        $batchSize = 100;

        for ($start = 1; $start <= $totalRecords; $start += $batchSize) {
            $end = min($start + $batchSize - 1, $totalRecords);
            InsertOrderData::dispatch($start, $end);
        }
    }
}
