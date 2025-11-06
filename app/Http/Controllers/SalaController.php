<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sala\StoreSalaRequest;
use App\Http\Requests\Sala\StoreSalaRequestWithInvitationsRequest;
use App\Http\Requests\Sala\UpdateSalaRequest;
use App\Http\Resources\SalaResource;
use App\Http\Resources\UserSalaRoleResource;
use App\Http\Resources\UserSalaRolesGetSalasMeResource;
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

    public function indexMe(Request $request)
    {
        $user = $request->get('userFromMiddleware');
        $userSalaRoles = UserSalaRole::where('user_id', $user->id)->get();

        $userSalaRoles->each(function ($userSalaRole) {
            $userSalaRole->usuarios = UserSalaRole::select(
                'users.id',
                'users.name',
                'roles.name as sala_role'
            )
                ->where('sala_id', $userSalaRole->sala_id)
                ->where('user_id', '!=', $userSalaRole->user_id)
                ->join('users', 'user_sala_roles.user_id', '=', 'users.id')
                ->join('roles', 'user_sala_roles.role_id', '=', 'roles.id')
                ->get();
        });

        return response()->json([
            'status' => '1',
            "salas" => UserSalaRolesGetSalasMeResource::collection($userSalaRoles)
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

        // Creamos la sala
        $sala = Sala::create([
            'user_id' => $user->id,
            'name' => $request->name,
        ]);

        // Asignar al creador como ADMIN
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
     * storeWithInvitations (Crea una sala y envía invitaciones a los emails proporcionados)
     * @author Lluís Ferrater
     * @param StoreSalaRequestWithInvitationsRequest $request Request con los datos validados de la sala e invitaciones
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el mensaje
     */
    public function storeWithInvitations(StoreSalaRequestWithInvitationsRequest $request)
    {
        $user = $request->get('userFromMiddleware');

        // Crear la sala
        $sala = Sala::create([
            'user_id' => $user->id,
            'name' => $request->name,
        ]);

        // Asignar al creador como ADMIN
        $userSalaRole = UserSalaRole::create([
            'user_id' => $user->id,
            'sala_id' => $sala->id,
            'role_id' => 1,
        ]);

        // Crear invitaciones si se proporcionaron emails
        $invitacionesCreadas = 0;
        if ($request->has('invitaciones') && is_array($request->invitaciones)) {
            foreach ($request->invitaciones as $invitacion) {
                $userInvitado = User::where('email', $invitacion['email'])->first();
                
                if ($userInvitado && $userInvitado->id !== $user->id) {
                    \App\Models\Invitacion::create([
                        'user_invitador_id' => $user->id,
                        'user_invitado_id' => $userInvitado->id,
                        'sala_id' => $sala->id,
                    ]);
                    $invitacionesCreadas++;
                }
            }
        }

        return response()->json([
            'status' => '1',
            'message' => 'Sala creada correctamente' . ($invitacionesCreadas > 0 ? " y {$invitacionesCreadas} invitación(es) enviada(s)" : ''),
            'sala' => new UserSalaRoleResource($userSalaRole),
            'invitaciones_enviadas' => $invitacionesCreadas
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

        // Usuarios
        $sala->usuarios = UserSalaRole::select(
            'users.id',
            'users.name',
            'roles.name as sala_role'
        )
            ->where('sala_id', $id)
            ->where('user_id', '!=', $user->id)
            ->join('users', 'user_sala_roles.user_id', '=', 'users.id')
            ->join('roles', 'user_sala_roles.role_id', '=', 'roles.id')
            ->get();

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
     * updateUserRole (Actualiza el rol de un usuario en una sala)
     * @author Lluís Ferrater
     * @param Request $request
     * @param int $id (Id de la sala)
     * @param int $userId (Id del usuario a modificar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el mensaje
     */


    public function updateUserRole(Request $request, $id, $userId)
    {
        $user = $request->get('userFromMiddleware');
        $userSalaRole = UserSalaRole::where('sala_id', $id)->get();

        // Verifico que el usuario autenticado sea ADMIN de la sala
        $this->autorizoUpdateSobreSala($user, $userSalaRole);

        // Validar que el role_id existe en la tabla roles
        $request->validate([
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        // Verifico que el usuario a modificar existe en la sala
        $targetUserSalaRole = UserSalaRole::where('sala_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$targetUserSalaRole) {
            return response()->json([
                'status' => '0',
                'message' => 'Usuario no encontrado en esta sala'
            ], Response::HTTP_NOT_FOUND);
        }

        // No permitir que se modifique a sí mismo
        if ($user->id == $userId) {
            return response()->json([
                'status' => '0',
                'message' => 'No puedes modificar tu propio rol'
            ], Response::HTTP_FORBIDDEN);
        }

        // Actualizar el rol
        $targetUserSalaRole->role_id = $request->role_id;
        $targetUserSalaRole->save();

        // Obtener la información del usuario que hace la petición
        $myUserSalaRole = UserSalaRole::where('sala_id', $id)
            ->where('user_id', $user->id)
            ->with(['sala', 'role'])
            ->first();

        // Cargar otros usuarios de la sala (desde la perspectiva del usuario autenticado)
        $myUserSalaRole->usuarios = UserSalaRole::select(
            'users.id',
            'users.name',
            'roles.name as sala_role'
        )
            ->where('sala_id', $myUserSalaRole->sala_id)
            ->where('user_id', '!=', $myUserSalaRole->user_id)
            ->join('users', 'user_sala_roles.user_id', '=', 'users.id')
            ->join('roles', 'user_sala_roles.role_id', '=', 'roles.id')
            ->get();

        return response()->json([
            'status' => '1',
            'message' => 'Rol actualizado correctamente',
            'sala' => new UserSalaRoleResource($myUserSalaRole)
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
                'message' => 'No tienes permiso para ver esta sala'
            ], Response::HTTP_FORBIDDEN));
        }
    }
}
