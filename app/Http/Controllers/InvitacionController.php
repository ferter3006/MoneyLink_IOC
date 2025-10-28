<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invitacion\CreateInvitacionRequest;
use App\Http\Requests\Invitacion\EliminateInvitacionRequest;
use App\Http\Requests\Invitacion\RespondeInvitacionRequest;
use App\Http\Resources\InvitacionResource;
use App\Models\Invitacion;
use App\Models\User;
use App\Models\UserSalaRole;
use Illuminate\Http\Request;

/**
 * Controlador de invitaciones
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: No hay validaciones de tokens por que no es necesario,
 * ya que los tokens se validan en el middleware antes de llegar al controlador
 */
class InvitacionController extends Controller
{
    /**
     * Muestra la lista de invitaciones para el usuario autenticado.
     * @author Lluís Ferrater
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la lista de invitaciones
     */
    
    public function index_recibidas(Request $request)
    {
        $userFromMiddleware = request()->get('userFromMiddleware');
        $invitaciones = Invitacion::where('user_invitado_id', $userFromMiddleware->id)->get();

        return response()->json([
            'status' => '1',
            'invitaciones' => InvitacionResource::collection($invitaciones)
        ]);
    }

    /**
     * Muestra la lista de invitaciones enviadas por el usuario autenticado.
     * @author Lluís Ferrater
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la lista de invitaciones
     */
    
    public function index_enviadas(Request $request)
    {
        $userFromMiddleware = request()->get('userFromMiddleware');
        $invitaciones = Invitacion::where('user_invitador_id', $userFromMiddleware->id)->get();

        return response()->json([
            'status' => '1',
            'invitaciones' => InvitacionResource::collection($invitaciones)
        ]);
    }

    /**
     * Crea una nueva invitación.
     * @author Lluís Ferrater
     * @param CreateInvitacionRequest $request Request con los datos validados de la invitación
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el mensaje de éxito
     */
    
    public function create(CreateInvitacionRequest $request)
    {
        $userFromMiddleware = request()->get('userFromMiddleware');
        $data = $request->all();
        $salaId = $data['sala_id'];
        $userInvitado = User::where('email', $data['email_invitado'])->first();

        Invitacion::create([
            'user_invitador_id' => $userFromMiddleware->id,
            'user_invitado_id' => $userInvitado->id,
            'sala_id' => $salaId,
        ]);

        return response()->json([
            'status' => '1',
            'message' => 'Invitación enviada correctamente'
        ]);
    }

    /**
     * Responde a una invitación.
     * @author Lluís Ferrater
     * @param Request $request
     * @param int $id (Id de la invitación a responder)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el mensaje de éxito
     */

    public function responder(RespondeInvitacionRequest $request, int $id)
    {
        $userFromMiddleware = request()->get('userFromMiddleware');
        $respuesta = $request->input('respuesta');
        $invitacion = Invitacion::find($id);

        $testMEssage = '';

        if ($respuesta) {
            UserSalaRole::create([
                'user_id' => $userFromMiddleware->id,
                'sala_id' => $invitacion->sala_id,
                'role_id' => 2, // Role de "User"
            ]);

            $invitacion->delete();
            $testMEssage = 'aceptada';
        } else {
            $invitacion->delete();
            $testMEssage = 'rechazada';
        }

        return response()->json([
            'status' => '1',
            'message' => 'Invitación ' . $testMEssage . ' correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invitacion $invitacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invitacion $invitacion)
    {
        //
    }

    /**
     * Elimina una invitación.
     * @author Lluís Ferrater
     * @param Invitacion $invitacion Invitación a eliminar
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el mensaje de éxito
     */
    
    public function destroy(EliminateInvitacionRequest $request, int $id)
    {
        $invitacion = Invitacion::find($id);
        $invitacion->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Invitación eliminada correctamente'
        ]);
    }
}
