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
                'password' => Hash::make('t34m1tmm'),
                'password_show' => 't34m1tmm',
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
                'password' => Hash::make('Superman2000@'),
                'password_show' => 'Superman2000@',
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
        ];

        // Generate additional users with Faker
        for ($i = 0; $i < $usersPerRegion - count($predefinedUsers); $i++) {
            $name = $faker->name; // Generate a random Indonesian name
            $username = strtolower(str_replace(' ', '.', $name)); // Create username from name
            $email = strtolower(str_replace(' ', '.', $name)) . '@example.com'; // Create email from name

            // Randomly assign role as either 'user' or 'supplier'
            $role = $faker->randomElement(['supplier']);

            $predefinedUsers[] = [
                'username' => $username, // Use the generated username
                'name' => $name, // Use the generated name
                'email' => $email, // Use the generated email
                'status' => 'y',
                'all_supplier' => 'n',
                'password' => Hash::make('password'),
                'password_show' => 'password',
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
