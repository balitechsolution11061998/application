<?php

namespace App\Http\Controllers;

use App\Models\Tutorials;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    //
    public function index()
    {
        return view('website');
    }

    public function data()
    {
        $tutorials = Tutorials::paginate(9); // Adjust the number of items per page as needed
        return response()->json($tutorials);
    }

    public function show($id)
    {
        $tutorials = Tutorials::find($id); // Adjust the number of items per page as needed
        return response()->json($tutorials);
    }
}
