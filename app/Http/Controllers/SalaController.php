<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSalaRoleResource;
use App\Models\Sala;
use App\Models\UserSalaRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalaController extends Controller
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

    public function store(Request $request)
    {
        $user = $request->get('userFromMiddleware');

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:45',
                Rule::unique('salas')->where(function ($query) use ($user) {
                    return $query->where('user_id', $user->id);
                })
            ],
        ], [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no debe tener más de 45 caracteres',
            'name.unique' => 'Ya tienes una sala con este nombre, se un poco más original!',
        ]);

        $user = $request->get('userFromMiddleware');

        $sala = Sala::create([
            'user_id' => $user->id,
            'name' => $request->name,
        ]);

        $userSalaRole = UserSalaRole::create([
            'user_id' => $user->id,
            'sala_id' => $sala->id,
            'role_id' => 1,
        ]);

        return response()->json([
            'status' => '1',
            'message' => 'Sala creada correctamente',
            'sala' => new UserSalaRoleResource($userSalaRole)
        ]);
    }
}
