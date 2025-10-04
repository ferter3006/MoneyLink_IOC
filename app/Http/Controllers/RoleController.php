<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        $users = User::all();

        return response()->json([
            'status' => '1',
            'roles' => $roles,
            'users' => $users
        ]);
    }
}
