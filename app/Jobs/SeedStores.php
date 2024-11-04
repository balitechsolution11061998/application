<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SeedStores implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Create a Faker instance with Indonesian locale
        $faker = Faker::create('id_ID');

        // Define region mapping for Bali (example)
        $regionMapping = [
            1 => 'MM', // Region 1
            2 => 'JP3', // Region 2
            3 => 'JP4', // Region 3
            4 => 'JP5', // Region 4
            5 => 'JP6', // Region 5
            6 => 'JP7', // Region 6
            7 => 'JP8', // Region 7
            8 => 'JP9', // Region 8
            9 => 'JP10', // Region 9
            10 => 'JP11', // Region 10
        ];

        // Generate 5000 store entries
        for ($i = 0; $i < 5000; $i++) {
            $region = $faker->numberBetween(1, 10); // Randomly select a region
            $storeIdentifier = $regionMapping[$region] . '-' . ($i + 1); // Format the store identifier

            DB::table('store')->insert([
                'store' => $storeIdentifier, // Use the formatted store identifier
                'store_name' => $faker->company, // Generates a company name in Indonesian
                'store_add1' => $faker->streetAddress, // Generates a street address
                'store_add2' => $faker->optional()->streetAddress, // Optional secondary address
                'store_city' => $faker->city, // Generates a city name in Indonesian
                'region' => $region, // Store the region number
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
