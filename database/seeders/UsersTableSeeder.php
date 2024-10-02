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

        // Calculate the number of users to create per region
        $totalUsers = 50;
        $usersPerRegion = intval($totalUsers / $regions->count()); // Users per region
        // Dispatch a job to create users for each region
        foreach ($regions as $region) {
            CreateUsersForRegionJob::dispatch($region->id, $usersPerRegion);
        }

        $this->command->info('User creation jobs have been dispatched to the queue.');
    }
}
