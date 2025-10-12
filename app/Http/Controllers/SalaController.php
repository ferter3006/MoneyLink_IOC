<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sala\StoreSalaRequest;
use App\Http\Requests\Sala\UpdateSalaRequest;
use App\Http\Resources\SalaResource;
use App\Http\Resources\UserSalaRoleResource;
use App\Models\Sala;
use App\Models\User;
use App\Models\UserSalaRole;
use Illuminate\Database\Eloquent\Collection;
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
    public function store(StoreSalaRequest $request)
    {
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
        $userSalaRole = UserSalaRole::where('sala_id', $id)->get();

        $this->autorizoSobreSala($user, $userSalaRole);

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

    public function update(UpdateSalaRequest $request, $id)
    {
        $user = $request->get('userFromMiddleware');
        $userSalaRole = UserSalaRole::where('sala_id', $id)->get();

        $this->autorizoUpdateSobreSala($user, $userSalaRole);

        $sala = Sala::find($id);
        $sala->name = $request->name;
        $sala->save();  // Guardamos los cambios

        return response()->json([
            'status' => '1',
            'message' => 'Sala actualizada correctamente',
            'sala' => new SalaResource($sala)
        ]);
    }

    public function delete(Request $request, $id)
    {
        $user = $request->get('userFromMiddleware');
        $userSalaRole = UserSalaRole::where('sala_id', $id)->get();

        $this->autorizoUpdateSobreSala($user, $userSalaRole);

        $sala = Sala::find($id);
        $sala->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Sala eliminada correctamente'
        ]);
    }


    ///////////////////////////////////////////
    // Funciones auxiliares
    ///////////////////////////////////////////

    public function autorizoUpdateSobreSala(User $user, Collection $userSalaRoles)
    {
        if ($userSalaRoles->isEmpty()) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Sala no encontrada'
            ], 404));
        }

        if ($userSalaRoles->where('user_id', $user->id)->where('role_id', 1)->isEmpty()) {
            abort(response()->json([
                'status' => '0',
                'message' => 'No tienes permiso para modificar esta sala'
            ], 403));
        }
    }

    public function autorizoSobreSala(User $user, Collection $userSalaRoles)
    {
        if ($userSalaRoles->isEmpty()) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Sala no encontrada'
            ], 404));
        }

        if ($userSalaRoles->where('user_id', $user->id)->isEmpty()) {
            abort(response()->json([
                'status' => '0',
                'message' => 'No tienes permiso para modificar esta sala'
            ], 403));
        }
    }
}
