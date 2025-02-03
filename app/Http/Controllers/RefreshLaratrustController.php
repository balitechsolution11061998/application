<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class RefreshLaratrustController extends Controller
{
    public function refreshLaratrust(Request $request)
    {
        // Initialize a variable to track transaction status
        $transactionActive = false;

        try {
            // Start a database transaction
            DB::beginTransaction();
            $transactionActive = true;

            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('users')->truncate(); // Truncate users table
            DB::table('role_user')->truncate(); // Truncate role_user table
            DB::table('roles')->truncate(); // Truncate roles table
            DB::table('permissions')->truncate(); // Truncate permissions table

            // Call the Artisan command to refresh the Laratrust seeder
            Artisan::call('db:seed', ['--class' => 'LaratrustSeeder']);

            // Call the Artisan command to run the UsersTableSeeder
            Artisan::call('db:seed', ['--class' => 'UsersTableSeeder']);

            // Commit the transaction
            DB::commit();

            // Auto logout the user
            Auth::logout();

            // Auto login the user again (assuming you have the user's credentials)
            // You can retrieve the user from the database or use session data
            $user = Auth::user(); // Get the currently authenticated user
            Auth::login($user); // Log the user back in

            return Response::json([
                'message' => 'Laratrust seeder and UsersTableSeeder refreshed successfully. You have been logged out and logged back in.'
            ], 200);
        } catch (\Exception $e) {
            // Check if a transaction is active before rolling back
            if ($transactionActive) {
                DB::rollBack();
            }

            return Response::json([
                'message' => 'Error refreshing Laratrust seeder: ' . $e->getMessage()
            ], 500);
        } finally {
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
