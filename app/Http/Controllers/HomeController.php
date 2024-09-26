<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $loggedInUsers = User::where('is_logged_in', true)->get(); // Adjust according to your logic
        return view('home', compact('loggedInUsers'));
    }
}
