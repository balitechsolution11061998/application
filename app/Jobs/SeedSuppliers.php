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

    }
}
