<?php

namespace App\Docs\Swagger;

/**
 * @OA\Tag(
 *     name="SalaObjective",
 *     description="Endpoints para gestionar los objetivos mensuales de una sala."
 * )
 */

class SalaObjectiveDoc
{
    /**
     * @OA\Get(
     *     path="/sala_objectives/{salaId}/{m}",
     *     summary="Obtener el objetivo de una sala en un mes concreto",
     *     tags={"SalaObjective"},
     *     @OA\Parameter(
     *         name="salaId",
     *         in="path",
     *         required=true,
     *         description="ID de la sala",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="m",
     *         in="path",
     *         required=true,
     *         description="Mes relativo (0=actual, -1=anterior, etc)",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/SalaObjectiveResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado"
     *     )
     * )
     */
    public function getObjectiveByMonth() {}

    /**
     * @OA\Get(
     *     path="/sala_objectives/{salaId}",
     *     summary="Obtener los objetivos de los últimos 12 meses de una sala",
     *     tags={"SalaObjective"},
     *     @OA\Parameter(
     *         name="salaId",
     *         in="path",
     *         required=true,
     *         description="ID de la sala",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 additionalProperties={
     *                     "oneOf": [
     *                         {"type": "null"},
     *                         {"type": "object", "ref": "#/components/schemas/SalaObjectiveResource"}
     *                     ]
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado"
     *     )
     * )
     */
    public function getObjectivesLast12Months() {}

    /**
     * @OA\Post(
     *     path="/sala_objectives/{salaId}",
     *     summary="Crear o actualizar el objetivo de una sala para el mes actual",
     *     tags={"SalaObjective"},
     *     @OA\Parameter(
     *         name="salaId",
     *         in="path",
     *         required=true,
     *         description="ID de la sala",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="number", format="float", example=150.00)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/SalaObjectiveResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function createOrUpdateObjective() {}
}
