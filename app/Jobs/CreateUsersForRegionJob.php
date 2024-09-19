<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateUsersForRegionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $regionId;
    protected $specialEmail = 'sulaksana60@gmail.com'; // Special email for superadministrator

    /**
     * Create a new job instance.
     */
    public function __construct($regionId)
    {
        $this->regionId = $regionId; // Set the region ID for the job
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $roles = ['superadministrator', 'administrator', 'user'];

        // Fetch role IDs
        $roleIds = Role::whereIn('name', $roles)->pluck('id', 'name')->toArray();

        // Special role for superadministrator
        $superAdminRoleId = $roleIds['superadministrator'];

        // Expanded list of Indonesian names and addresses
        $indonesianFirstNames = [
            'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eka', 'Fajar', 'Gita', 'Hadi', 'Ika', 'Joko',
            'Kirana', 'Lia', 'Maya', 'Nina', 'Oka', 'Putra', 'Rina', 'Sari', 'Tari', 'Uli',
            'Vina', 'Wati', 'Yani', 'Zahra', 'Aditya', 'Bayu', 'Chandra', 'Dian', 'Eli',
            'Fitria', 'Gilang', 'Hani', 'Intan', 'Jasmine', 'Kusuma', 'Lestari', 'Mukti',
            'Nadia', 'Omar', 'Puspita', 'Rizki', 'Sinta', 'Teguh', 'Umar', 'Vivi', 'Wahyu',
            'Xenia', 'Yuliana', 'Zulfa'
        ];

        $indonesianLastNames = [
            'Pratama', 'Sari', 'Putra', 'Wijaya', 'Halim', 'Susanto', 'Sutrisno', 'Santoso',
            'Indah', 'Utami', 'Wulandari', 'Rahman', 'Yusuf', 'Nur', 'Hendri', 'Dewanto',
            'Adinugraha', 'Prabowo', 'Anggraini', 'Mulyani', 'Maharani', 'Sundari', 'Lestari',
            'Mahendra', 'Kusuma', 'Wati', 'Rini', 'Dewi', 'Nugroho', 'Hadi', 'Lestari', 'Risma'
        ];

        $indonesianAddresses = [
            'Jl. Merdeka No.1, Jakarta', 'Jl. Sudirman No.45, Bandung', 'Jl. Pahlawan No.12, Surabaya',
            'Jl. Gatot Subroto No.34, Yogyakarta', 'Jl. Diponegoro No.78, Medan', 'Jl. Raya Kuta No.56, Bali',
            'Jl. Alun-Alun No.21, Makassar', 'Jl. Bunga Raya No.9, Semarang', 'Jl. Raya Bogor No.10, Depok',
            'Jl. Kebon Jeruk No.8, Jakarta', 'Jl. Cirebon No.30, Karawang', 'Jl. Pembangunan No.22, Palembang'
        ];

        $indonesianPhoneNumbers = [
            '081234567890', '082345678901', '083456789012', '084567890123', '085678901234',
            '086789012345', '087890123456', '088901234567', '089012345678', '081098765432'
        ];

        // Generate 400 users for the region
        $usersBatch = [];
        for ($i = 1; $i <= 400; $i++) {
            $username = "user" . $i;
            $email = ($i === 1) ? $this->specialEmail : "user{$i}@example.com";

            // Determine the role: assign superadministrator role to the special email
            $role = ($email === $this->specialEmail) ? $superAdminRoleId : $roleIds[array_rand($roleIds)];

            // Randomly select Indonesian names, addresses, and phone numbers
            $firstName = $indonesianFirstNames[array_rand($indonesianFirstNames)];
            $lastName = $indonesianLastNames[array_rand($indonesianLastNames)];
            $fullName = "$firstName $lastName";
            $address = $indonesianAddresses[array_rand($indonesianAddresses)];
            $phoneNumber = $indonesianPhoneNumbers[array_rand($indonesianPhoneNumbers)];

            // Add user data to the batch
            $plainPassword = ($email === $this->specialEmail) ? 'Superman2000@' : 'password'; // Use a specific password for superadministrator
            $usersBatch[] = [
                'name' => $fullName,
                'username' => strtolower($firstName) . $i, // Username combining first name and index
                'profile_picture' => '/storage/logo.png',
                'email' => $email,
                'password' => Hash::make($plainPassword), // Hashed password
                'password_show' => $plainPassword, // Store plain password for reference
                'region_id' => $this->regionId, // Assign to this region
                'address' => $address,
                'phone_number' => $phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert users in bulk
        User::insert($usersBatch);

        // Assign roles for the created users
        foreach ($usersBatch as $userData) {
            $user = User::where('email', $userData['email'])->first();
            // Ensure superadministrator role is assigned to the special email
            $userRole = ($userData['email'] === $this->specialEmail) ? $superAdminRoleId : $roleIds[array_rand($roleIds)];
            $user->roles()->sync([$userRole]); // Assign the role
        }
    }


}
