<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            'user',
            'supplier',
        ];

        // Fetch role IDs
        $roleIds = DB::table('roles')->whereIn('name', $roles)->pluck('id', 'name');

        // Predefined users
        $predefinedUsers = [
            [
                'username' => 99, // Integer username
                'name' => 'Administrator',
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
                'role' => 'superadministrator',
            ],
            [
                'username' => 219811991, // Integer username
                'name' => 'I Wayan Bayu Sulaksana',
                'email' => 'sulaksana60@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('password'),
                'password_show' => 'password',
                'link_sync' => null,
                'region' => $regionId,
                'address' => 'Jl. Bali Merdeka',
                'phone_number' => '081219811991',
                'role' => 'administrator',
            ],
            // Other predefined users...
        ];

        DB::transaction(function () use ($predefinedUsers, $usersPerRegion, $regionId, $roleIds) {
            // Insert predefined users first
            $users = [];
            foreach ($predefinedUsers as $user) {
                // Check if user already exists
                if (!DB::table('users')->where('username', $user['username'])->exists()) {
                    $users[] = $user;
                }
            }

            // Generate random users with integer usernames
            $maxUsername = DB::table('users')->max('username') ?? 1000;

            for ($i = count($users); $i < $usersPerRegion; $i++) {
                $users[] = [
                    'username' => ++$maxUsername, // Increment integer username
                    'name' => "User Region {$regionId} - {$i}",
                    'email' => "user_region{$regionId}_{$maxUsername}@example.com",
                    'photo' => '/default.png',
                    'status' => 'y',
                    'all_supplier' => 'n',
                    'password' => Hash::make('password'),
                    'password_show' => 'password',
                    'link_sync' => null,
                    'region' => $regionId,
                    'address' => "Jl. Region {$regionId} - {$i}",
                    'phone_number' => '081' . str_pad($i, 8, '0', STR_PAD_RIGHT),
                    'role' => 'user',
                ];
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
