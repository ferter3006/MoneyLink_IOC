<?php

namespace App\Docs\Swagger;



class RolesDoc
{

    /**
     * @OA\Get(
     *     path="/api/roles",     
     *     summary="Lista todos los roles del sistema",
     *     description="Obtiene la lista completa de roles disponibles en el sistema (ADMIN, USER). Solo usuarios con rol ADMIN pueden consultar esta lista.",
     *     tags={"Roles"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/RoleResource")
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
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - Solo usuarios ADMIN pueden consultar roles",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     )
     * )     
     */
    public function index() {}
}
