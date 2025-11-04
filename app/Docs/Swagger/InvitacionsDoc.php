<?php

namespace App\Docs\Swagger;

class InvitacionsDoc
{

    /**
     * @OA\Get(
     *     path="/api/invitaciones/recibidas",
     *     summary="Lista las invitaciones recibidas",
     *     description="Obtiene todas las invitaciones pendientes que ha recibido el usuario autenticado para unirse a diferentes salas",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de invitaciones recibidas obtenida exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="invitaciones",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/InvitacionResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */

    public function index_recibidas() {}

    /**
     * @OA\Get(
     *     path="/api/invitaciones/enviadas",
     *     summary="Lista las invitaciones enviadas",
     *     description="Obtiene todas las invitaciones pendientes que el usuario autenticado ha enviado a otros usuarios para unirse a sus salas",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de invitaciones enviadas obtenida exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="invitaciones",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/InvitacionResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */


    public function index_enviadas() {}

    /**
     * @OA\Post(
     *     path="/invitaciones",
     *     summary="Crea una nueva invitación",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="email", type="string", format="email", example="pepe@pepe.com"),
     *            @OA\Property(property="sala_id", type="integer", example=1)
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invitación creada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Invitación enviada correctamente")
     *         )
     *     )
     * )
     */
    public function create() {}

    /**
     * @OA\Post(
     *     path="/invitaciones/{id}/responder",
     *     summary="Responde a una invitación. Solo el destinatario puede responder.",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id de la invitación a responder",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="aceptada", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invitación respondida correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Invitación respondida correctamente")
     *         )
     *     )
     * )
     */
    public function responder() {}

    /**
     * @OA\Delete(
     *     path="/invitaciones/{id}",
     *     summary="Elimina una invitación. Solo el remitente puede eliminar una invitación",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id de la invitación a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invitación eliminada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Invitación eliminada correctamente")
     *         )
     *     )
     * )
     */

    public function destroy() {}
}
