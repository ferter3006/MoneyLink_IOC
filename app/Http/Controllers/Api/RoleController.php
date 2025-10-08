<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

   
    public function index(Request $request)
    {
        $roles = Role::orderBy('id')->get();

        return response()->json([
            'status' => '1',
            'roles' => RoleResource::collection($roles),
        ]);
    }
}
