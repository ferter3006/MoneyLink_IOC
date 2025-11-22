<?php

namespace App\Docs\Swagger;

/**
 * @OA\Tag(
 *     name="Objetivos de Sala",
 *     description="Endpoints para gestionar los objetivos mensuales de una sala."
 * )
 */

class SalaObjectiveDoc
{
    /**
     * @OA\Get(
     *     path="/sala_objectives/{salaId}/{m}",
     *     summary="Obtener el objetivo de una sala en un mes concreto",
     *     tags={"Objetivos de Sala"},
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
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="status", type="string", example="1"),
    *             @OA\Property(
    *                 property="data",
    *                 allOf={@OA\Schema(ref="#/components/schemas/SalaObjectiveResource")},
    *                 example={"11-2025": "150.00"}
    *             )
    *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado"
     *     )
     * )
     */
    public function getObjectiveByMonth()
    {
    }

    /**
     * @OA\Get(
     *     path="/sala_objectives/{salaId}",
     *     summary="Obtener los objetivos de los últimos 12 meses de una sala",
     *     tags={"Objetivos de Sala"},
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
    *             @OA\Property(property="message", type="string", example="Objetivos de los últimos 12 meses. Si un mes no sale en la lista es que no tiene objetivo asignado."),
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(allOf={@OA\Schema(ref="#/components/schemas/SalaObjectiveResource")}, example={"09-2025": "130.00"})
    *             )
    *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrado"
     *     )
     * )
     */
    public function getObjectivesLast12Months()
    {
    }

    /**
     * @OA\Post(
     *     path="/sala_objectives/{salaId}",
     *     summary="Crear o actualizar el objetivo de una sala para el mes actual",
     *     tags={"Objetivos de Sala"},
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
    public function createOrUpdateObjective()
    {
    }
}
