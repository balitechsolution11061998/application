<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Make sure to import the User model
use Laratrust\Models\LaratrustRole;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Predefined users with actual names
        $predefinedUsers = [
            [
                'username' => 99,
                'name' => 'Admin Notification',
                'email' => 'notification@supplier.m-mart.co.id',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('t34m1tmm'), // Set password for admin
                'link_sync' => 'https://supplier.m-mart.co.id',
                'region' => 1, // Set a default region ID
                'address' => 'Jl. Merdeka No.1, Jakarta',
                'phone_number' => '081234567890',
                'role' => 'administrator',
            ],
            [
                'username' => 219811991,
                'name' => 'I Wayan Bayu Sulaksana',
                'email' => 'sulaksana60@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('Superman2000@'), // Set password for superadmin
                'link_sync' => null,
                'region' => 1, // Set a default region ID
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
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => 'Jl. Supplier No.1, Jakarta',
                'phone_number' => '081234567891',
                'role' => 'supplier',
            ],
            // Add other predefined users here...
        ];

        // Insert predefined users into the database
        foreach ($predefinedUsers as $userData) {
            // Create the user
            $user = User::create([
                'username' => $userData['username'],
                'name' => $userData['name'],
                'email' => $userData['email'],
                'status' => $userData['status'],
                'all_supplier' => $userData['all_supplier'],
                'password' => $userData['password'],
                'link_sync' => $userData['link_sync'],
                'region' => $userData['region'],
                'address' => $userData['address'],
                'phone_number' => $userData['phone_number'],
            ]);

            // Assign the role using Laratrust
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->addRole($role);
            }
        }
    }
}
