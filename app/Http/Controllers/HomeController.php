<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $activities = ActivityLog::where('action_type', 'logout')->latest()->get();
        return view('home', compact('activities'));
    }
}
