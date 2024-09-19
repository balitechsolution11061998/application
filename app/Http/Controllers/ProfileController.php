<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/profile_pictures', $fileName);

            return response()->json(['success' => true, 'file_path' => $filePath]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded.']);
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
