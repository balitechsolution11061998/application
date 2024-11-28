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

        // Insert the specified supplier entry as the first row
        DB::table('supplier')->insert([
            'supp_code' => '111133', // Static supplier code
            'supp_name' => 'TRI DELTA DEWATA, CV', // Supplier name
            'terms' => 30, // Payment terms
            'contact_name' => 'YUDI BRAHMANTA- 081805561868', // Contact person
            'contact_phone' => '0361-8562668', // Contact phone number
            'contact_fax' => '0361-432410/8632178', // Contact fax
            'email' => 'data_not_found@example.com', // Placeholder email for "Data Not Found"
            'address_1' => 'Jl. Gn. Mas III C6', // Address line 1
            'address_2' => null, // Optional address line 2 not provided
            'city' => 'Denpasar', // City from the form
            'post_code' => '80361', // Postal code (you can adjust it as needed)
            'tax_ind' => 'Y', // Tax indicator
            'tax_no' => null, // No tax number provided
            'retur_ind' => 'N', // Return indicator
            'consig_ind' => 'N', // Consignment indicator
            'status' => 'Y', // Active status
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Generate 4,999 additional supplier entries
        for ($i = 0; $i < 4999; $i++) {
            DB::table('supplier')->insert([
                'supp_code' => $faker->unique()->numerify('######'), // 6-digit unique supplier code
                'supp_name' => $faker->company, // Random company name
                'terms' => $faker->numberBetween(1, 30), // Random payment terms
                'contact_name' => $faker->name, // Random contact person name
                'contact_phone' => $faker->phoneNumber, // Random phone number
                'contact_fax' => $faker->optional()->phoneNumber, // Optional fax number
                'email' => $faker->unique()->safeEmail, // Random unique email address
                'address_1' => $faker->streetAddress, // Random address line 1
                'address_2' => $faker->optional()->streetAddress, // Optional address line 2
                'city' => $faker->city, // Random city name
                'post_code' => $faker->postcode, // Random postal code
                'tax_ind' => $faker->randomElement(['Y', 'N']), // Random tax indicator
                'tax_no' => $faker->optional()->numerify('##########'), // Optional 10-digit tax number
                'retur_ind' => $faker->randomElement(['Y', 'N']), // Random return indicator
                'consig_ind' => $faker->randomElement(['Y', 'N']), // Random consignment indicator
                'status' => $faker->randomElement(['Y', 'N']), // Random status
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
