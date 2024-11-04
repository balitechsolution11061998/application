<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SeedSuppliers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Create a Faker instance with Indonesian locale
        $faker = Faker::create('id_ID');

        // Generate 10,000 supplier entries
        for ($i = 0; $i < 10000; $i++) {
            DB::table('supplier')->insert([
                'supp_code' => $faker->unique()->randomNumber(8), // Unique supplier code
                'supp_name' => $faker->company, // Generates a company name in Indonesian
                'terms' => $faker->numberBetween(1, 30), // Payment terms
                'contact_name' => $faker->name, // Contact person name
                'contact_phone' => $faker->phoneNumber, // Contact phone number
                'contact_fax' => $faker->optional()->phoneNumber, // Optional fax number
                'email' => $faker->unique()->safeEmail, // Unique email address
                'address_1' => $faker->streetAddress, // Address line 1
                'address_2' => $faker->optional()->streetAddress, // Optional address line 2
                'city' => $faker->city, // City name
                'post_code' => $faker->postcode, // Postal code
                'tax_ind' => $faker->randomElement(['Y', 'N']), // Tax indicator
                'tax_no' => $faker->optional()->randomNumber(10), // Optional tax number
                'retur_ind' => $faker->randomElement(['Y', 'N']), // Return indicator
                'consig_ind' => $faker->randomElement(['Y', 'N']), // Consignment indicator
                'status' => $faker->randomElement(['Y', 'N']), // Status
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
