<?php

namespace App\Docs\Swagger;

class TiquetDoc
{

    /**
     * @OA\Post(
     *     path="/api/tiquets",
     *     tags={"Tiquets"},
     *     security={{"bearerAuth"={}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="sala_id", type="integer", example=1),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="es_ingreso", type="boolean", example=true),
     *             @OA\Property(property="description", type="string", example="Pizza"),
     *             @OA\Property(property="amount", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Tiquet creado correctamente"),
     *             @OA\Property(property="tiquet", ref="#/components/schemas/TiquetResource")
     *         )
     *     )
     * )
     * 
     */

    public function store() {}

    /**
     * @OA\Patch(
     *     path="/api/tiquets/{id}",
     *     tags={"Tiquets"},
     *     security={{"bearerAuth"={}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del tiquet a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="es_ingreso", type="boolean", example=true),
     *             @OA\Property(property="description", type="string", example="Pizza"),
     *             @OA\Property(property="amount", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Tiquet actualizado correctamente"),
     *             @OA\Property(property="tiquet", ref="#/components/schemas/TiquetResource")
     *         )
     *     )
     * )
     * 
     */

    public function update() {}


    /**
     * @OA\Delete(
     *     path="/api/tiquets/{id}",
     *     tags={"Tiquets"},
     *     security={{"bearerAuth"={}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del tiquet a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Tiquet eliminado correctamente")
     *         )
     *     )
     * )
     * 
     */

    public function delete() {}

    /**
     * @OA\Get(
     *     path="/api/tiquets/{id}",
     *     tags={"Tiquets"},
     *     security={{"bearerAuth"={}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del tiquet a mostrar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="tiquet", ref="#/components/schemas/TiquetResource")
     *         )
     *     )
     * )
     * 
     */

    public function show() {}
}
