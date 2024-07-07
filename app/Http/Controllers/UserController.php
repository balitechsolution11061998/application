<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    //
    use LogsActivity;

    public function index()
    {
        return view('users.index');
    }

    public function data(Request $request){
        try {
            // Log the activity of accessing the create page using the trait
            $this->logActivity('Accessed create page', 'User accessed the create user page');
            if ($request->ajax()) {
                $data = User::with('jabatan','department','cabang')->latest()->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                        $btn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            // Log the error
            $this->logError('An error occurred while accessing the create page', $e);

            return $e->getMessage();

        }
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        // Generate a new password (optional)
        $newPassword = Str::random(8); // Example: Generate a random 8-character password
        $user->password_show = $newPassword;

        // Update user's password
        $user->password = bcrypt($newPassword);
        $user->save();

        // Send email with password reset information
        Mail::to($user->email)->send(new ResetPasswordEmail($user, $newPassword));

        return redirect()->back()->with('success', 'Password reset email sent successfully.');
    }

    public function edit($id)
    {
        return view('users.create');
    }

    public function dataEdit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function create()
    {
        try {
            // Log the activity of accessing the create page using the trait
            $this->logActivity('Accessed create page', 'User accessed the create user page');

            // Return the view for creating a user
            return view('users.create');
        } catch (\Exception $e) {
            // Log the error
            $this->logError('An error occurred while accessing the create page', $e);

            return $e->getMessage();

        }
    }

    public function store(Request $request)
    {

        // Determine if this is a create or update operation
        $isUpdate = $request->has('id');
        $user = $isUpdate ? User::findOrFail($request->input('id')) : new User();
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:10',
                $isUpdate ? Rule::unique('users')->ignore($user->id) : 'unique:users',
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $isUpdate ? Rule::unique('users')->ignore($user->id) : 'unique:users',
            ],
            'password' => $isUpdate ? 'sometimes|string|min:8' : 'required|string|min:8',
            'departments' => 'required|integer',
            'jabatan' => 'required|string|max:255',
            'cabang' => 'required|string|max:255',
            'no_handphone' => 'required|string|max:15',
            'nik' => 'required|string|max:16',
            'join_date' => 'required|date',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string',
            'about_us' => 'nullable|string',
            'status' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle the photo upload
        if ($request->hasFile('photo')) {
            $imageName = time().'.'.$request->photo->extension();
            $uploadedImage = $request->photo->storeAs('images', $imageName, 'public');
            $photoPath = 'storage/images/' . $imageName; // Store the path in the database
            $user->photo = $photoPath;
        }

        try {
            // Set user attributes
            $user->username = $request->input('username');
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if ($request->filled('password')) {
                $user->password_show = $request->input('password');
                $user->password = bcrypt($request->input('password'));
            }
            $user->kode_dept = $request->input('departments');
            $user->kode_jabatan = $request->input('jabatan');
            $user->kode_cabang = $request->input('cabang');
            $user->phone_number = $request->input('no_handphone');
            $user->nik = $request->input('nik');
            $user->alamat = $request->input('address');
            $user->about_us = $request->input('about_us');
            $user->join_date = $request->input('join_date');
            $user->status = $request->input('status') === 'on' ? 'y' : 'n';

            $user->save();

            $message = $isUpdate ? 'User updated successfully' : 'User created successfully';
            return response()->json(['message' => $message], $isUpdate ? 200 : 201);
        } catch (\Exception $e) {
            // Log the error using the LogsErrors trait
            $this->logError('An error occurred while accessing the save page', $e);

            // Return a JSON response with the error message
            return response()->json(['error' => 'Failed to save user', 'message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return Response::json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting user: ' . $e->getMessage());

            return Response::json(['error' => 'Failed to delete user', 'message' => $e->getMessage()], 500);
        }
    }


}
