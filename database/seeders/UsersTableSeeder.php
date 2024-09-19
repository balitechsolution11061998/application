<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Jobs\CreateUsersForRegionJob;
use App\Models\Region;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch all regions
        $regions = Region::all();

        // Dispatch a job to create 100 users per region
        foreach ($regions as $region) {
            CreateUsersForRegionJob::dispatch($region->id); // Pass region_id to the job
        }

        $this->command->info('User creation jobs have been dispatched to the queue.');
    }
}
