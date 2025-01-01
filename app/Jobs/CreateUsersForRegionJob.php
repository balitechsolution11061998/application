<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class CreateUsersForRegionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $regionId;
    public int $usersPerRegion;

    public function __construct(int $regionId, int $usersPerRegion)
    {
        $this->regionId = $regionId;
        $this->usersPerRegion = $usersPerRegion;
    }

    public function handle()
    {
        $regionId = $this->regionId;
        $usersPerRegion = $this->usersPerRegion;

        // Define roles
        $roles = [
            'superadministrator',
            'administrator',
            'supplier',
            'it',
            'md',
            'dc',
        ];

        // Fetch role IDs
        $roleIds = DB::table('roles')->whereIn('name', $roles)->pluck('id', 'name');

        // Initialize Faker
        $faker = Faker::create('id_ID'); // Use Indonesian locale

        // Predefined users with actual names
        $predefinedUsers = [
            [
                'username' => 99,
                'name' => 'Admin Notification',
                'email' => 'notification@supplier.m-mart.co.id',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('99@123'), // Set password for admin
                'password_show' => '99@123',
                'link_sync' => 'https://supplier.m-mart.co.id',
                'region' => $regionId,
                'address' => 'Jl. Merdeka No.1, Jakarta',
                'phone_number' => '081234567890',
                'profile_picture' => '/logo.png',
                'role' => 'administrator',
            ],
            [
                'username' => 219811991,
                'name' => 'I Wayan Bayu Sulaksana',
                'email' => 'sulaksana60@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('219811991@123'), // Set password for superadmin
                'password_show' => '219811991@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. Bali Merdeka',
                'phone_number' => '081219811991',
                'role' => 'superadministrator',
            ],
            [
                'username' => 111095, // Predefined supplier user
                'name' => 'SUKANDA DJAYA, PT',
                'email' => 'dpssmspv@diamond.co.id',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111095@123'), // Set password for supplier
                'password_show' => '111095@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. Supplier No.1, Jakarta',
                'phone_number' => '081234567891',
                'role' => 'supplier',
            ],
            // Predefined users for IT, MD, and DC
            [
                'username' => 'it_user',
                'name' => 'IT User',
                'email' => 'it_user@example.com',
                'status' => 'y',
                'all_supplier' => 'n',
                'password' => Hash::make('it_user@123'),
                'password_show' => 'it_user@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. IT No.1, Jakarta',
                'phone_number' => '081234567892',
                'role' => 'it',
            ],
            [
                'username' => 'md_user',
                'name' => 'Managing Director',
                'email' => 'md_user@example.com',
                'status' => 'y',
                'all_supplier' => 'n',
                'password' => Hash::make('md_user@123'),
                'password_show' => 'md_user@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. MD No.1, Jakarta',
                'phone_number' => '081234567893',
                'role' => 'md',
            ],
            [
                'username' => 'dc_user',
                'name' => 'Distribution Center',
                'email' => 'dc_user@example.com',
                'status' => 'y',
                'all_supplier' => 'n',
                'password' => Hash::make('dc_user@123'),
                'password_show' => 'dc_user@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. DC No.1, Jakarta',
                'phone_number' => '081234567894',
                'role' => 'dc',
            ],
            // New users to be added
            [
                'username' => 111254,
                'name' => 'BAHTERA WIRANIAGA INTERNUSA PT',
                'email' => 'finance2bali@pt-bahtera.co.id',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111254@123'), // Set password for supplier
                'password_show' => '111254@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. Bahtera No.1, Jakarta',
                'phone_number' => '081234567895',
                'role' => 'supplier',
            ],
            [
                'username' => 111188,
                'name' => 'SO GOOD FOOD, PT',
                'email' => 'gita.puspitasari@japfa.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111188@123'), // Set password for supplier
                'password_show' => '111188@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. So Good No.1, Jakarta',
                'phone_number' => '081234567896',
                'role' => 'supplier',
            ],
            [
                'username' => 151034,
                'name' => 'GAMBINO ARTISAN PRIMA PT. - KO',
                'email' => 'gambinocoffee@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('151034@123'), // Set password for supplier
                'password_show' => '151034@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. Gambino No.1, Jakarta',
                'phone_number' => '081234567897',
                'role' => 'supplier',
            ],
            [
                'username' => 111149,
                'name' => 'JARI PERKASA, CV',
                'email' => 'dirajariperkasa@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111149@123'), // Set password for supplier
                'password_show' => '111149@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. Jari No.1, Jakarta',
                'phone_number' => '081234567898',
                'role' => 'supplier',
            ],
            [
                'username' => 111157,
                'name' => 'MASUYA PPN',
                'email' => 'balirsm@masuya.co.id',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111157@123'), // Set password for supplier
                'password_show' => '111157@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. Masuya No.1, Jakarta',
                'phone_number' => '081234567899',
                'role' => 'supplier',
            ],
            [
                'username' => 162082,
                'name' => 'PANGAN MITRA BALI, CV',
                'email' => 'cvpangmitrabali@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('162082@123'), // Set password for supplier
                'password_show' => '162082@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. Pangan No.1, Jakarta',
                'phone_number' => '081234567900',
                'role' => 'supplier',
            ],
        ];

        // Generate additional users with Faker
        for ($i = 0; $i < $usersPerRegion - count($predefinedUsers); $i++) {
            $name = $faker->name; // Generate a random Indonesian name
            $username = strtolower(str_replace(' ', '.', $name)); // Create username from name
            $email = strtolower(str_replace(' ', '.', $name)) . '@example.com'; // Create email from name

            // Randomly assign role as either 'user' or 'supplier'
            $role = $faker->randomElement(['supplier', 'it', 'md', 'dc']); // Include new roles

            $predefinedUsers[] = [
                'username' => $username, // Use the generated username
                'name' => $name, // Use the generated name
                'email' => $email, // Use the generated email
                'status' => 'y',
                'all_supplier' => 'n',
                'password' => Hash::make($username . '@123'), // Set password based on username
                'password_show' => $username . '@123',
                'link_sync' => null,
                'region' => $regionId,
                'address' => $faker->address, // Generate a random address
                'phone_number' => '081' . str_pad($i, 8, '0', STR_PAD_RIGHT),
                'role' => $role, // Assign the randomly selected role
            ];
        }

        DB::transaction(function () use ($predefinedUsers, $regionId, $roleIds) {
            // Insert predefined users first
            $users = [];
            foreach ($predefinedUsers as $user) {
                // Check if user already exists
                if (!DB::table('users')->where('username', $user['username'])->exists()) {
                    $users[] = $user;
                }
            }

            // Insert users and assign roles
            foreach ($users as $user) {
                $role = $user['role'] ?? 'user';
                unset($user['role']);
                $user['created_at'] = Carbon::now();
                // Insert user and get the ID
                $userId = DB::table('users')->insertGetId($user);

                // Assign the role
                $roleId = $roleIds[$role] ?? null;
                if ($roleId) {
                    DB::table('role_user')->updateOrInsert(
                        [
                            'role_id' => $roleId,
                            'user_id' => $userId,
                            'user_type' => 'App\Models\User',
                        ],
                        []
                    );
                }
            }
        });
    }
}
