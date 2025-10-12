<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalaResource;
use App\Http\Resources\UserSalaRoleResource;
use App\Models\Sala;
use App\Models\UserSalaRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SalaController extends Controller
{

    // Listar las salas de un usuario
    // Solo informacion basica (sala_id, sala_name, role_id, role_name del user)
    public function index(Request $request)
    {
        $user = $request->get('userFromMiddleware');
        $userSalaRoles = UserSalaRole::where('user_id', $user->id)->get();

        return response()->json([
            'status' => '1',
            'salas' => UserSalaRoleResource::collection($userSalaRoles)
        ]);
    }

    // Crear sala

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

    // Mostraamos el estado de la sala en un mes en concreto
    // Se lista toda la informacion necesaria:
    // - Sumatorio de ingresos y egresos y balance
    // - Lista de tiquets (con sus categorias, es_ingreso, description y amount)
    // - ... etc
    
    public function show(Request $request, $id, $m)
    {
        $user = $request->get('userFromMiddleware');

        // Validar que el usuario tenga acceso a la sala
        $userSalaRole = UserSalaRole::where('user_id', $user->id)->where('sala_id', $id)->first();

        if (!$userSalaRole) {
            return response()->json([
                'status' => '0',
                'message' => 'No tienes acceso a esta sala'
            ], 403);
        }

        // Calculo mes deseado
        $fecha = now()->addMonths((int) $m);
        $mes = $fecha->month;
        $año = $fecha->year;
        $inicioMes = $fecha->copy()->startOfMonth();
        $finMes = $fecha->copy()->endOfMonth();

        // Sala
        $sala = Sala::with(['tiquets' => function ($query) use ($inicioMes, $finMes) {
            $query->whereBetween('created_at', [$inicioMes, $finMes]);
        }])->find($id);

        return response()->json([
            'status' => '1',
            'mes' => $mes,
            'año' => $año,
            'sala' => new SalaResource($sala)
        ]);
    }
}
