<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function getRoles()
    {
        $roles = \Laratrust\Models\Role::all();
        return response()->json($roles);
    }
}
