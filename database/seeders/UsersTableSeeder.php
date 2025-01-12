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
                'password_show' => 't34m1tmm', // Set password for admin
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
                'password_show' => 'Superman2000@', // Set password for superadmin
                'channel_id'=>'-4741355755',
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
                'password_show' => '111095@123', // Set password for supplier
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => 'Jl. Supplier No.1, Jakarta',
                'phone_number' => '081234567891',
                'role' => 'supplier',
            ],
            [
                'username' => 210314919, // Predefined supplier user
                'name' => 'NI LUH KADEK RISMA WULANDARI',
                'email' => 'bigm.sst@rcoid.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('12345678'), // Set password for supplier
                'password_show' => '12345678', // Set password for supplier
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '',
                'phone_number' => '',
                'role' => 'store',
            ],
            [
                'username' => 111254, // New user
                'name' => 'BAHTERA WIRANIAGA INTERNUSA PT',
                'email' => 'finance2bali@pt-bahtera.co.id',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111254@123'), // Set a password for the new user
                'password_show' => '111254@123', // Set a password for the new user
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '', // Add address if available
                'phone_number' => '', // Add phone number if available
                'role' => 'supplier', // Set the role for the new user
            ],
            [
                'username' => 111188, // New user
                'name' => 'SO GOOD FOOD, PT',
                'email' => 'gita.puspitasari@japfa.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111188@123'), // Set a password for the new user
                'password_show' => '111188@123', // Set a password for the new user
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '', // Add address if available
                'phone_number' => '', // Add phone number if available
                'role' => 'supplier', // Set the role for the new user
            ],
            [
                'username' => 151034, // New user
                'name' => 'GAMBINO ARTISAN PRIMA PT. - KO',
                'email' => 'gambinocoffee@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('151034@123'), // Set a password for the new user
                'password_show' => '151034@123', // Set a password for the new user
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '', // Add address if available
                'phone_number' => '', // Add phone number if available
                'role' => 'supplier', // Set the role for the new user
            ],
            [
                'username' => 111149, // New user
                'name' => 'JARI PERKASA, CV',
                'email' => 'dirajariperkasa@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111149@123'), // Set a password for the new user
                'password_show' => '111149@123', // Set a password for the new user
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '', // Add address if available
                'phone_number' => '', // Add phone number if available
                'role' => 'supplier', // Set the role for the new user
            ],
            [
                'username' => 111157, // New user
                'name' => 'MASUYA PPN',
                'email' => 'balirsm@masuya.co.id',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111157@123'), // Set a password for the new user
                'password_show' => '111157@123', // Set a password for the new user
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '', // Add address if available
                'phone_number' => '', // Add phone number if available
                'role' => 'supplier', // Set the role for the new user
            ],
            [
                'username' => 162082, // New user
                'name' => 'PANGAN MITRA BALI, CV',
                'email' => 'cvpanganmitrabali@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('162082@123'), // Set a password for the new user
                'password_show' => '162082@123', // Set a password for the new user
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '', // Add address if available
                'phone_number' => '', // Add phone number if available
                'role' => 'supplier', // Set the role for the new user
            ],
            [
                'username' => 162077, // New user
                'name' => 'CHEESE WORKS BALI, PT',
                'email' => 'cheeseworks1992@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('162077@123'), // Set a password for the new user
                'password_show' => '162077@123', // Set a password for the new user
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '', // Add address if available
                'phone_number' => '', // Add phone number if available
                'role' => 'supplier', // Set the role for the new user
            ],
            [
                'username' => 111225, // New user
                'name' => 'Kaifa Indonesia, PT',
                'email' => 'sulaksana60@gmail.com',
                'status' => 'y',
                'all_supplier' => 'y',
                'password' => Hash::make('111225@123'), // Set a password for the new user
                'password_show' => '111225@123', // Set a password for the new user
                'link_sync' => null,
                'region' => 1, // Set a default region ID
                'address' => '', // Add address if available
                'phone_number' => '', // Add phone number if available
                'role' => 'supplier', // Set the role for the new user
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
                'password_show' => $userData['password_show'],
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
