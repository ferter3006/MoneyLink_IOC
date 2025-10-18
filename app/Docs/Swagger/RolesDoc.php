<?php

namespace App\Docs\Swagger;



class RolesDoc
{

    /**
     * @OA\Get(
     *     path="/api/roles",     
     *     summary="Devuelve todos los roles. Requiere un token de tipo ADMIN.",
     *     description="Devuelve una lista con todos los roles",
     *     tags={"Roles"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/RoleResource")
     *             )
     *         )
     *     )     
     * )     
     */
    public function index() {}
}
