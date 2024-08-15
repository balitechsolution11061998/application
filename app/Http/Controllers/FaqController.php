<?php

namespace App\Http\Controllers;

use App\Models\Faq as ModelsFaq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    //
    public function index()
    {
        return response()->json(ModelsFaq::all());
    }
}
