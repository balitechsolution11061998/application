<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(){
        return view('management_user.users.index');
    }
    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            // Query to get user data
            $data = User::select('id','username', 'name', 'email','password_show','created_at');

            return Datatables::of($data)
                ->addColumn('actions', function($row){
                    // Return a set of buttons for each action: Edit, Delete, and Change Password, with Font Awesome icons
                    return '
                        <button type="button" class="btn btn-sm btn-primary" onclick="editUser('. $row->id .')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser('. $row->id .')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" onclick="changePassword('. $row->id .')">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    ';
                })
                ->rawColumns(['actions']) // Important for rendering HTML in the actions column
                ->make(true);
        }
    }

    public function verifySuperadminPassword(Request $request)
    {
        // Assuming 'superadministrator_password' is stored securely in the environment or database
        if ($request->password == "Superman2000@") {
            // Fetch the user's actual password from the database based on the selected row ID
            $user = User::find($request->user_id);

            if ($user) {
                return response()->json(['success' => true, 'password' => $user->password_show]);
            } else {
                return response()->json(['success' => false, 'message' => 'User not found.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Incorrect password.']);
        }
    }
}
