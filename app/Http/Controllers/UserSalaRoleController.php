<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSalaRoleResource;
use App\Models\User;
use App\Models\UserSalaRole;
use Illuminate\Http\Request;

class UserSalaRoleController extends Controller
{
    public function index(Request $request)
    {
        $userSalaRoles = UserSalaRole::all();

        return response()->json([
            'status' => '1',
            'userSalaRoles' => UserSalaRoleResource::collection($userSalaRoles)
        ]);
    }
}
