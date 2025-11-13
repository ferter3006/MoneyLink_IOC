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
     *     path="/api/invitaciones",
     *     summary="Crea una nueva invitación a una sala",
     *     description="Envía una invitación a un usuario registrado para que se una a una de tus salas. Solo puedes invitar a salas donde eres miembro. No puedes invitarte a ti mismo, invitar a usuarios que ya están en la sala, ni enviar invitaciones duplicadas.",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de la invitación",
     *         @OA\JsonContent(
     *            type="object",
     *            required={"email_invitado", "sala_id"},
     *            @OA\Property(
     *                property="email_invitado",
     *                type="string",
     *                format="email",
     *                description="Email del usuario registrado a invitar",
     *                example="amigo@example.com"
     *            ),
     *            @OA\Property(
     *                property="sala_id",
     *                type="integer",
     *                description="ID de la sala a la que se invita",
     *                example=1
     *            )
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invitación enviada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Invitación enviada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación - Email no existe, no estás en la sala, usuario ya en sala, invitación duplicada o intento de autoinvitación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email_invitado",
     *                     type="array",
     *                     @OA\Items(type="string", example="No puedes invitarte a ti mismo.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function create() {}

    /**
     * @OA\Post(
     *     path="/api/invitaciones/{id}",
     *     summary="Responde a una invitación",
     *     description="Permite al destinatario aceptar o rechazar una invitación a una sala. Si se acepta, el usuario se une a la sala con rol USER. Solo el destinatario puede responder.",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la invitación a responder",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=5
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Respuesta a la invitación",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"respuesta"},
     *             @OA\Property(
     *                 property="respuesta",
     *                 type="boolean",
     *                 description="true = aceptar, false = rechazar",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invitación respondida exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Invitación aceptada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - Solo el destinatario puede responder",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Invitación no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Invitación no encontrada")
     *         )
     *     )
     * )
     */
    public function responder() {}

    /**
     * @OA\Delete(
     *     path="/api/invitaciones/{id}",
     *     summary="Elimina una invitación",
     *     description="Permite al remitente cancelar una invitación pendiente. Solo el remitente puede eliminar la invitación.",
     *     tags={"Invitaciones"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la invitación a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=5
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Invitación eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Invitación eliminada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - Solo el remitente puede eliminar la invitación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Invitación no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Invitación no encontrada")
     *         )
     *     )
     * )
     */

    public function destroy() {}
}
