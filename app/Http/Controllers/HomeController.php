<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $loggedInUsers = User::leftJoin('authentications_monitoring', 'users.id', '=', 'authentications_monitoring.user_id')
        ->where('users.is_logged_in', true)
        ->where('authentications_monitoring.action_type', 'login')
        ->select('users.*', 'authentications_monitoring.*')
        ->get();
        return view('home', compact('loggedInUsers'));
    }
}
