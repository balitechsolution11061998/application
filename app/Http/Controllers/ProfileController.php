<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function uploadProfilePicture(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the request has a file
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Create a unique filename based on the current time
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Store the file in the specified directory
            $filePath = $file->storeAs('profile_pictures', $fileName, 'public'); // Using 'public' disk for visibility

            // Generate a URL for the uploaded file
            $fileUrl = asset('storage/' . $filePath); // Generates a public URL to access the file

            // Return a JSON response with success status and file URL
            return response()->json([
                'success' => true,
                'file_url' => $fileUrl // Return the URL instead of the path
            ], 200);
        }

        // Return an error response if no file is uploaded
        return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
    }

    public function removePicture(Request $request)
    {
        // Validate the request if needed
        // $request->validate([...]);

        // Get the current authenticated user
        $user = auth()->user(); // or any method to get the current user

        // Retrieve the current profile picture path from the user's record
        $imagePath = $user->profile_picture;

        if ($imagePath && Storage::exists('public/' . $imagePath)) {
            // Delete the file from storage
            Storage::delete('public/' . $imagePath);

            // Update user's profile_picture field to null or default value
            $user->profile_picture = null; // or set to default image path if you have one
            $user->save();

            return response()->json(['message' => 'Image removed successfully!']);
        }

        return response()->json(['message' => 'Image not found.'], 404);
    }

}
