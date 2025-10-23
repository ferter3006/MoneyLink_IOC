<?php

namespace App\Docs\Swagger;

class SalasDoc
{

    /**
     * @OA\Get(
     *     path="/api/salas/me",
     *     summary="Lista las salas de un usuario. Requiere un token valido.",
     *     description="Lista las salas de un usuario",
     *     tags={"Salas"},
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
     *                 property="salas",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UserSalaRoleResource")
     *             )
     *         )
     *     )
     * )
     */

    public function index() {}

    /**
     * @OA\Post(
     *     path="/api/salas",
     *     summary="Crea una sala. Requiere un token valido.",
     *     description="Crea una sala",
     *     tags={"Salas"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Sala 1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Sala creada correctamente"),
     *             @OA\Property(property="sala", type="object", ref="#/components/schemas/UserSalaRoleResource")
     *         )
     *     )
     * )
     * 
     */
    public function store() {}

    /**
     * @OA\Get(
     *     path="/api/salas/{id}/{m}",
     *     summary="Muestra el estado de la sala en un mes en concreto. Requiere un token válido.",
     *     description="Muestra el estado de la sala en un mes en concreto. 0 => mes actual, -2 => 2 meses atrás, 4 => 4 meses adelante ... etc",
     *     tags={"Salas"},
     *     security={{"bearerAuth"={}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Id de la sala",
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="m",
     *         in="path",
     *         required=true,
     *         description="Mes deseado",
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="mes", type="integer", example=1),
     *             @OA\Property(property="anio", type="integer", example=2023),
     *             @OA\Property(property="inicioMes", type="string", example="2023-01-01 00:00:00"),
     *             @OA\Property(property="finMes", type="string", example="2023-01-31 23:59:59"),
     *             @OA\Property(property="sala", ref="#/components/schemas/SalaResource"),
     *             @OA\Property(
     *                 property="tiquets",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/TiquetResource")
     *             ),
     *             @OA\Property(property="balance", type="integer", example=2023),
     *             @OA\Property(property="sumatorio", type="integer", example=2023)
     *         )
     *     )
     * )
     */


    public function show() {}

    /**
     * @OA\Patch(
     *     path="/api/salas/{id}",
     *     summary="Actualiza una sala. Requiere un token válido.",
     *     description="Actualiza una sala",
     *     tags={"Salas"},
     *     security={{"bearerAuth"={}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id de la sala",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Sala 1")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Sala actualizada correctamente"),
     *             @OA\Property(property="sala", ref="#/components/schemas/SalaResource")
     *         )
     *     )
     * )
     */


    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/salas/{id}",
     *     summary="Elimina una sala. Requiere un token valido.",
     *     description="Elimina una sala",
     *     tags={"Salas"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id de la sala",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Sala eliminada correctamente"),   
     *         )
     *     )
     * )
     * */
    public function delete() {}
}
