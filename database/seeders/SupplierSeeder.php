<?php

namespace Database\Seeders;

use App\Jobs\SeedSuppliers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SeedSuppliers::dispatch();
    }
}
