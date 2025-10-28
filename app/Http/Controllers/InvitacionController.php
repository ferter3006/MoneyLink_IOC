<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invitacion\CreateInvitacionRequest;
use App\Http\Resources\InvitacionResource;
use App\Models\Invitacion;
use App\Models\User;
use Illuminate\Http\Request;

class InvitacionController extends Controller
{
    /**
     * Muestra la lista de invitaciones para el usuario autenticado.
     * @author Lluís Ferrater
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la lista de invitaciones
     */
    public function index(Request $request)
    {
        $userFromMiddleware = request()->get('userFromMiddleware');
        $invitaciones = Invitacion::where('user_invitado_id', $userFromMiddleware->id)->get();

        return response()->json([
            'status' => '1',
            'invitaciones' => InvitacionResource::collection($invitaciones)
        ]);
    }

    /**
     * Show the form for creating a new resource.
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invitacion $invitacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invitacion $invitacion)
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
     * Remove the specified resource from storage.
     */
    public function destroy(Invitacion $invitacion)
    {
        //
    }
}
