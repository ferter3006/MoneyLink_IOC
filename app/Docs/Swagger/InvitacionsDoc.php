<?php

namespace App\Docs\Swagger;

class InvitacionsDoc
{

    /**
     * @OA\Get(
     *     path="/invitaciones/recibidas",
     *     summary="Lista las invitaciones recibidas por el usuario autenticado",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de invitaciones recibidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(
     *                 property="invitaciones",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/InvitacionResource")
     *             )
     *         )
     *     )
     * )
     */

    public function index_recibidas() {}

    /**
     * @OA\Get(
     *     path="/invitaciones/enviadas",
     *     summary="Lista las invitaciones enviadas por el usuario autenticado",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de invitaciones enviadas",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="invitaciones",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/InvitacionResource")
     *             )
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
