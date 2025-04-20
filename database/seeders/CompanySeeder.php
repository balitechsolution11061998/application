<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the INTERNAL company that's referenced in the ProductsSeeder
        Company::create([
            'name' => 'Internal Company',
            'code' => 'INTERNAL',
            'address' => 'Jl. Main Office No. 123',
            'phone' => '081234567890',
            'email' => 'info@internalcompany.com',
            'logo' => 'internal-logo.png',
            'is_active' => true,
        ]);

        // Add some other example companies
        $companies = [
            [
                'name' => 'Partner Company A',
                'code' => 'PARTNER-A',
                'address' => 'Jl. Partner A No. 456',
                'phone' => '081234567891',
                'email' => 'info@partnera.com',
                'logo' => 'partner-a-logo.png',
                'is_active' => true,
            ],
            [
                'name' => 'Partner Company B',
                'code' => 'PARTNER-B',
                'address' => 'Jl. Partner B No. 789',
                'phone' => '081234567892',
                'email' => 'info@partnerb.com',
                'logo' => 'partner-b-logo.png',
                'is_active' => true,
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}