<?php

namespace Database\Seeders;

use App\Models\Company; // Using Eloquent model instead of DB facade
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Prevent duplicate seeding in production
        if (app()->environment('production') && Company::exists()) {
            return;
        }

        $companies = [
            [
                'name' => 'DUMMY COMPANY',
                'code' => 'DUMMY',
                'type' => 'dummy',
                'description' => 'Dummy data for testing purposes',
                'contact_person' => 'Dummy Person',
                'contact_email' => 'dummy@example.com',
                'contact_phone' => '081234567890',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
                'slug' => Str::slug('DUMMY COMPANY'), // Added slug for URLs
            ],
            [
                'name' => 'Internal Operations',
                'code' => 'INTERNAL',
                'type' => 'internal',
                'description' => 'Main internal company handling core operations',
                'contact_person' => 'Internal Manager',
                'contact_email' => 'internal@company.com',
                'contact_phone' => '082134567890',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'slug' => Str::slug('Internal Operations'),
            ],
            [
                'name' => 'Kangwuan Partner',
                'code' => 'KANGWUAN',
                'type' => 'external',
                'description' => 'Official Kangwuan distribution partner',
                'contact_person' => 'Kangwuan Representative',
                'contact_email' => 'partner@kangwuan.com',
                'contact_phone' => '083134567890',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'slug' => Str::slug('Kangwuan Partner'),
            ],
            [
                'name' => 'CBS Solutions',
                'code' => 'CBS',
                'type' => 'external',
                'description' => 'Certified CBS operations partner',
                'contact_person' => 'CBS Solutions Manager',
                'contact_email' => 'info@cbssolutions.com',
                'contact_phone' => '084134567890',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'slug' => Str::slug('CBS Solutions'),
            ],
            [
                'name' => 'Marketing Team',
                'code' => 'MARKETING',
                'type' => 'external',
                'description' => 'Dedicated external marketing partner',
                'contact_person' => 'Marketing Director',
                'contact_email' => 'marketing@partner.com',
                'contact_phone' => '085134567890',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'slug' => Str::slug('Marketing Team'),
            ],
        ];

        // Use Eloquent for better model handling
        foreach ($companies as $company) {
            Company::firstOrCreate(
                ['code' => $company['code']], // Unique identifier
                $company
            );
        }
    }
}