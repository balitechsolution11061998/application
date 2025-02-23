<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeSupplierController extends Controller
{
    //
    public function index(){
          // Fetch counts for each section
          $purchaseOrdersCount = 0; // Replace with your actual model logic
          $receivingCount = 0; // Replace with your actual model logic
          $returnsCount = 0; // Replace with your actual model logic
          $tandaTerimaCount = 0; // Replace with your actual model logic

          // Get the authenticated supplier's profile
          $supplier = Auth::user(); // Assuming the supplier is the authenticated user
          return view('welcome', compact('purchaseOrdersCount', 'receivingCount', 'returnsCount', 'tandaTerimaCount', 'supplier'));
        }
}
