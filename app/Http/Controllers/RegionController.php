<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    //
    public function data()
    {
        $regions = Region::all(); // Assuming you have a 'regions' table
        return response()->json($regions);
    }

    public function getRegions(Request $request): JsonResponse
    {
        try {
            $query = Region::select('id', 'name');

            // Check if there is a search term in the request
            if ($request->has('search') && !empty($request->search)) {
                $searchTerm = $request->search;
                // Apply a where clause to filter regions based on the search term
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('name', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Fetch regions based on the query
            $regions = $query->get();

            // Log the successful retrieval of regions
            activity()
                ->performedOn(new Region())
                ->log('Fetched regions successfully.');

            // Return the regions as a JSON response
            return response()->json(['regions' => $regions]);
        } catch (Exception $e) {
            // Log the error message
            activity()
                ->performedOn(new Region())
                ->log('Error fetching regions: ' . $e->getMessage());

            // Return a JSON response with an error message
            return response()->json(['error' => 'Failed to fetch regions.'], 500);
        }
    }
}
