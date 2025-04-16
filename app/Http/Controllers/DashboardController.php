<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function dashboardPos(){
        return view('pos.dashboard');
    }
}
