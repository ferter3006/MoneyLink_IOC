<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSalaRoleResource;
use App\Models\UserSalaRole;
use Illuminate\Http\Request;

class UserSalaRoleController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->get('userFromMiddleware');
        $userSalaRoles = UserSalaRole::where('user_id', $user->id)->get();

        return response()->json([
            'status' => '1',
            'userSalaRoles' => UserSalaRoleResource::collection($userSalaRoles)
        ]);
    }
}
