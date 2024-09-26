<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    //
    public function data()
    {
        $regions = Region::all(); // Assuming you have a 'regions' table
        return response()->json($regions);
    }
}
