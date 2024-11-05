<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $loggedInUsers = User::join('user_activity_logs', 'users.id', '=', 'user_activity_logs.user_id')
        ->where('users.is_logged_in', true)
        ->where('user_activity_logs.action_type', 'login')
        ->select('users.*', 'user_activity_logs.*')
        ->get();
        return view('home', compact('loggedInUsers'));
    }
}
