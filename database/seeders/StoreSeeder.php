<?php

namespace Database\Seeders;

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
        // Create a Faker instance with Indonesian locale
        $faker = Faker::create('id_ID');

        // Generate 5000 store entries
        for ($i = 0; $i < 5000; $i++) {
            DB::table('store')->insert([
                'store' => $i + 1, // Assuming store is a unique identifier
                'store_name' => $faker->company, // Generates a company name in Indonesian
                'store_add1' => $faker->streetAddress, // Generates a street address
                'store_add2' => $faker->optional()->streetAddress, // Optional secondary address
                'store_city' => $faker->city, // Generates a city name in Indonesian
                'region' => $faker->numberBetween(1, 10), // Adjust based on your regions
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
