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
use Illuminate\Http\Response;

/**
 * Controlador de salas
 * @author Lluís Ferrater
 * @version 1.0     
 * NOTA: No hay validaciones de tokens por que no es necesario,
 * ya que los tokens se validan en el middleware antes de llegar al controlador
 */
class SalaController extends Controller
{

    /**
     * index (Muestra todas las salas)
     * @author Lluís Ferrater
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la colección de salas
     */
    public function index(Request $request)
    {
        $user = $request->get('userFromMiddleware');
        $userSalaRoles = UserSalaRole::where('user_id', $user->id)->get();

        return response()->json([
            'status' => '1',
            'salas' => UserSalaRoleResource::collection($userSalaRoles)
        ]);
    }

    /**
     * store (Crea una sala)
     * @author Lluís Ferrater
     * @param StoreSalaRequest $request Request con los datos validados de la sala
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el mensaje
     */
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


    /**
     * show (Muestra una sala con su información en un mes en concreto)
     * @author Lluís Ferrater
     * @param Request $request
     * @param int $id (Id de la sala a mostrar)
     * @param int $m (Mes a mostrar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la info de la sala en el mes/año elegido
     */

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

    /**
     * update (Actualiza una sala)
     * @author Lluís Ferrater
     * @param UpdateSalaRequest $request Request con los datos validados de la sala
     * @param int $id (Id de la sala a actualizar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status, el mensaje y la sala actualizada
     */
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

    /**
     * delete (Elimina una sala)
     * @author Lluís Ferrater
     * @param Request $request
     * @param int $id (Id de la sala a eliminar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el mensaje
     */
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

    /**
     * autorizoUpdateSobreSala (Autoriza acceso de modificación o no sobre una sala)
     * @author Lluís Ferrater
     * @param User $user (Usuario que quiere ver la sala)
     * @param Collection $userSalaRoles (Colección de userSalaroles del usuario que quiere modificar la sala)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON abortando si no tiene permiso
     */
    public function autorizoUpdateSobreSala(User $user, Collection $userSalaRoles)
    {
        if ($userSalaRoles->isEmpty()) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Sala no encontrada'
            ], Response::HTTP_NOT_FOUND));
        }

        if ($userSalaRoles->where('user_id', $user->id)->where('role_id', 1)->isEmpty()) {
            abort(response()->json([
                'status' => '0',
                'message' => 'No tienes permiso para modificar esta sala'
            ], Response::HTTP_FORBIDDEN));
        }
    }

    /**
     * autorizoSobreSala (Autoriza acceso de visualización o no sobre una sala)
     * @author Lluís Ferrater
     * @param User $user (Usuario que quiere ver la sala)
     * @param Collection $userSalaRoles (Colección de userSalaroles del usuario que quiere ver la sala)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON abortando si no tiene permiso
     */
    public function autorizoSobreSala(User $user, Collection $userSalaRoles)
    {
        if ($userSalaRoles->isEmpty()) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Sala no encontrada'
            ], Response::HTTP_NOT_FOUND));
        }

        if ($userSalaRoles->where('user_id', $user->id)->isEmpty()) {
            abort(response()->json([
                'status' => '0',
                'message' => 'No tienes permiso para modificar esta sala'
            ], Response::HTTP_FORBIDDEN));
        }
    }
}
