<?php

namespace App\Docs\Swagger;


 /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Devuelve todos los Rroless",
     *     description="Devuelve todos los roles y usuarios registrados",
     *     tags={"Gestion de Roles"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Admin")
     *                 )
     *             ),
     *         )
     *     )
     * )
     */

 class RolesDoc {}