<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserController extends Controller
{
    //
    use LogsActivity;

    public function index()
    {
        return view('users.index');
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
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'departments' => 'required|integer',
            'jabatan' => 'required|string|max:255',
            'no_handphone' => 'required|string|max:15',
            'nik' => 'required|string|max:16',
            'join_date' => 'required|date',
            'provinsi' => 'required|integer',
            'kabupaten' => 'required|integer',
            'kecamatan' => 'required|integer',
            'kelurahan' => 'required|integer',
            'user_role' => 'required|integer',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Create a new user
            $user = new User();
            $user->username = $request->input('username');
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->kode_dept = $request->input('departments');
            $user->kode_jabatan = $request->input('jabatan');
            $user->phone_number = $request->input('no_handphone');
            $user->nik = $request->input('nik');
            $user->join_date = $request->input('join_date');
            $user->provinsi_id = $request->input('provinsi');
            $user->kabupaten_id = $request->input('kabupaten');
            $user->kecamatan_id = $request->input('kecamatan');
            $user->kelurahan_id = $request->input('kelurahan');
            $user->save();

            return response()->json(['message' => 'User created successfully'], 201);
        } catch (Exception $e) {
            // Log the error using the LogsErrors trait
            $this->logError('An error occurred while accessing the create page', $e);

            // Return a JSON response with the error message
            return response()->json(['error' => 'Failed to create user', 'message' => $e->getMessage()], 500);
        }
    }


}
