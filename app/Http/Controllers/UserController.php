<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //
    use LogsActivity;

    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        try {
            // Log the activity of accessing the create page using the trait
            $this->logActivity('Accessed create page', 'User accessed the create user page');

            // Return the view for creating a user
            return view('users.create');
        } catch (\Exception $e) {
            // Log the error
            $this->logError('An error occurred while accessing the create page', $e);

            return $e->getMessage();

        }
    }
}
