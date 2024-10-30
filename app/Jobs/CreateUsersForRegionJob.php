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
use Illuminate\Support\Facades\DB;

class CreateUsersForRegionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 1200;
    protected $regionId;
    protected $usersPerRegion;
    protected $specialEmail = 'sulaksana60@gmail.com'; // Special email for superadministrator
    protected $batchSize = 1000; // Number of users per batch

    /**
     * Create a new job instance.
     */
    public function __construct($regionId, $usersPerRegion)
    {
        $this->regionId = $regionId; // Set the region ID for the job
        $this->usersPerRegion = $usersPerRegion; // Number of users to create for this region
    }

    /**
     * Generate a random 9-digit username.
     */
    private function generateRandomUsername(): string
    {
        return str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $roles = ['superadministrator', 'administrator', 'user', 'admin_md_region', 'acct', 'bdm', 'data_analyst_md', 'it', 'md_ho', 'md_manager', 'md_region', 'opr', 'supplier', 'wh'];

        // Fetch role IDs
        $roleIds = Role::whereIn('name', $roles)->pluck('id', 'name')->toArray();

        // Track if superadministrator and administrator have already been created
        $superAdminCreated = false;
        $adminCreated = false;

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

        // Generate users for the region
        for ($batch = 0; $batch < ceil($this->usersPerRegion / $this->batchSize); $batch++) {
            $usersBatch = [];
            for ($i = 1; $i <= $this->batchSize; $i++) {
                $index = ($batch * $this->batchSize) + $i;
                if ($index > $this->usersPerRegion) {
                    break;
                }

                $email = ($index === 1 && $this->regionId === 1) ? $this->specialEmail : "user{$this->regionId}_{$index}@example.com";

                // Assign role based on flags for administrator and superadministrator
                if (!$superAdminCreated && $email === $this->specialEmail) {
                    $role = $roleIds['superadministrator'];
                    $superAdminCreated = true;
                } elseif (!$adminCreated) {
                    $role = $roleIds['administrator'];
                    $adminCreated = true;
                } else {
                    $role = $roleIds[array_rand(array_diff_key($roleIds, ['superadministrator' => '', 'administrator' => '']))];
                }

                // Randomly select Indonesian names, addresses, and phone numbers
                $firstName = $indonesianFirstNames[array_rand($indonesianFirstNames)];
                $lastName = $indonesianLastNames[array_rand($indonesianLastNames)];
                $fullName = "$firstName $lastName";
                $address = $indonesianAddresses[array_rand($indonesianAddresses)];
                $phoneNumber = $indonesianPhoneNumbers[array_rand($indonesianPhoneNumbers)];

                // Generate a random 9-digit username
                $username = $this->generateRandomUsername();

                // Add user data to the batch
                $plainPassword = ($email === $this->specialEmail) ? 'Superman2000@' : 'password';
                $usersBatch[] = [
                    'name' => $fullName,
                    'username' => $username,
                    'profile_picture' => '/logo.png',
                    'email' => $email,
                    'password' => Hash::make($plainPassword),
                    'password_show' => $plainPassword,
                    'region_id' => $this->regionId,
                    'address' => $address,
                    'phone_number' => $phoneNumber,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert users in bulk
            DB::transaction(function () use ($usersBatch, $roleIds) {
                User::insert($usersBatch);

                // Prepare role assignments in bulk
                $roleAssignments = [];
                foreach ($usersBatch as $userData) {
                    $user = User::where('email', $userData['email'])->first();
                    $userRole = ($userData['email'] === $this->specialEmail) ? $roleIds['superadministrator'] : $roleIds[array_rand($roleIds)];
                    $roleAssignments[] = [
                        'role_id' => $userRole,
                        'user_id' => $user->id,
                        'user_type' => 'App\Models\User',
                    ];
                }

                // Insert into role_user table
                DB::table('role_user')->insert($roleAssignments);
            });

            // Optionally, log progress to keep track of batch processing
            \Log::info("Batch $batch of users for region {$this->regionId} created.");
        }
    }

}
