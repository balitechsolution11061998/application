<?php
namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class UsersImport implements ToModel, WithChunkReading, WithBatchInserts
{
    // Set the chunk size
    public function chunkSize(): int
    {
        return 250; // Adjust chunk size based on your server's capacity
    }

    // Set batch insert size
    public function batchSize(): int
    {
        return 100; // Insert 100 rows at a time for better performance
    }

    public function model(array $row)
    {
        // Skip the first row (header)
        if ($row[0] == 'SUPPLIER') {
            return null;
        }

        $password = $this->generatePassword($row[0]);
        $emails = explode(',', $row[2]);
        $email = trim($emails[0]);

        try {
            DB::transaction(function () use ($row, $password, $email) {
                $existingUser = User::where('username', $row[0])
                    ->where('email', $email)
                    ->first();

                // If the user exists, delete it before inserting a new one
                if ($existingUser) {
                    $existingUser->delete();
                }

                $userData = [
                    'username' => $row[0],
                    'name' => $row[1],
                    'email' => $email,
                    'password' => bcrypt($password),
                    'password_show' => $password,
                    'region_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert the user data and return the User instance
                $user = User::create($userData);

                // Assign the 'supplier' role
                $user->syncRoles(['supplier']);
            });

            // Update progress
            $this->updateProgress(1, 1);
        } catch (\Exception $e) {
            \Log::error("Error processing row: " . json_encode($row) . " - " . $e->getMessage());
        }
    }

    // Function to generate a simple password
    private function generatePassword($username)
    {
        $specialChar = '@';
        return strtolower($username) . $specialChar . '123'; // Example: 'supplier@123'
    }

    // Update progress in the cache
    private function updateProgress($current, $total)
    {
        $progress = ($current / $total) * 100; // Calculate percentage
        Cache::put('import_progress', $progress); // Store progress in cache
    }
}
