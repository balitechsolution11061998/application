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
            1 => 'MM',   // Region 1
            2 => 'JP3',  // Region 2
            3 => 'JP4',  // Region 3
            4 => 'JP5',  // Region 4
            5 => 'JP6',  // Region 5
            6 => 'JP7',  // Region 6
            7 => 'JP8',  // Region 7
            8 => 'JP9',  // Region 8
            9 => 'JP10', // Region 9
            10 => 'JP11' // Region 10
        ];

        // Insert first specific entry
        DB::table('store')->insert([
            'store' => 79,
            'store_name' => 'MM PRG',
            'store_add1' => 'JL. PURI GADING',
            'store_add2' => null,
            'store_city' => 'JIMBARAN',
            'region' => 1,
            'latitude' => -8.7737, // Latitude for Jimbaran, Bali
            'longitude' => 115.1668, // Longitude for Jimbaran, Bali
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert "DC Minimart" entry
        DB::table('store')->insert([
            'store' => 40,
            'store_name' => 'DC Minimart',
            'store_add1' => 'JL. NYANGNYANG SARI NO. 7A',
            'store_add2' => 'TUBAN',
            'store_city' => 'BADUNG',
            'region' => 1, // Region code for DC Minimart
            'latitude' => -8.7465, // Latitude for Tuban, Bali
            'longitude' => 115.1677, // Longitude for Tuban, Bali
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('store')->insert([
            'store' => 89,
            'store_name' => 'MM LG5',
            'store_add1' => 'JL. RAYA LEGIAN',
            'store_add2' => null,
            'store_city' => 'BADUNG',
            'region' => 1,
            'latitude' => -8.7093, // Latitude for Legian, Bali
            'longitude' => 115.1710, // Longitude for Legian, Bali
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('store')->insert([
            'store' => 95,
            'store_name' => 'MM CG2',
            'store_add1' => 'JL. RAYA CANGGU, BR. ASEMAN KAWAN, KUTA UTARA',
            'store_add2' => null,
            'store_city' => 'BADUNG',
            'region' => 1,
            'latitude' => -8.6486, // Latitude for Canggu, Bali
            'longitude' => 115.1384, // Longitude for Canggu, Bali
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // Generate remaining random entries
        for ($i = 41; $i <= 5000; $i++) {
            $region = $faker->numberBetween(1, 10); // Randomly select a region
            $storeIdentifier = $regionMapping[$region] . '-' . ($i - 40); // Format the store identifier

            DB::table('store')->insert([
                'store' => $i,
                'store_name' => $storeIdentifier,
                'store_add1' => $faker->streetAddress,
                'store_add2' => $faker->optional()->streetAddress,
                'store_city' => $faker->city,
                'region' => $region,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
