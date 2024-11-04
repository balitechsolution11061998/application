<?php

namespace Database\Seeders;

use App\Jobs\SeedStores;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeedStores::dispatch();
    }
}
