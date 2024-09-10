<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role; // Ensure you have a Role model

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['superadministrator', 'administrator', 'user'];
        $specialUserEmail = 'sulaksana60@gmail.com';

        // Fetch role IDs
        $roleIds = Role::whereIn('name', $roles)->pluck('id', 'name')->toArray();
        $specialUserRoleId = $roleIds['superadministrator'];

        // Start transaction to improve performance
        DB::transaction(function () use ($roleIds, $specialUserEmail, $specialUserRoleId) {
            $usersBatch = [];

            for ($i = 1; $i <= 10000; $i++) {
                // Generate a unique username
                $username = ($i === 1) ? 'specialuser' : "user$i";

                // Determine role for the current user
                $role = ($i === 1) ? $specialUserRoleId : $roleIds[array_rand($roleIds)];

                // Plain-text password for the special user and others
                $plainPassword = ($i === 1) ? 'Superman2000@' : 'password'; // Assign specific password to Superadmin

                // Add user data to the batch, including `password_show`
                $usersBatch[] = [
                    'name' => "User $i",
                    'username' => $username,
                    'email' => ($i === 1) ? $specialUserEmail : "user$i@example.com",
                    'password' => Hash::make($plainPassword), // Store the hashed password
                    'password_show' => $plainPassword, // Store the plain-text password for reference
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert users in batches of 1000 for better performance
                if ($i % 1000 == 0) {
                    // Insert the batch of users
                    User::insert($usersBatch);

                    // Fetch the last inserted 1000 users and assign roles
                    $lastUsers = User::latest('id')->take(1000)->get();
                    foreach ($lastUsers as $user) {
                        // Assign the role to each user
                        $userRole = ($user->email === $specialUserEmail) ? $specialUserRoleId : $roleIds[array_rand($roleIds)];
                        $user->roles()->sync([$userRole]); // Sync the role using role ID
                    }

                    // Clear the batch array
                    $usersBatch = [];

                    // Output progress in the console
                    $this->command->info("$i users created");
                }
            }

            // Handle the special user separately if not in the last batch
            if (!is_null($specialUserEmail)) {
                $specialUser = User::where('email', $specialUserEmail)->first();
                if ($specialUser) {
                    $specialUser->roles()->sync([$specialUserRoleId]); // Sync the role using role ID
                }
            }
        });
    }
}
