<?php

namespace App\Docs\Swagger;

class StatsDoc
{
    /**
     * @OA\Get(
     *     path="/api/stats/mes/{salaId}/{m}",
     *     summary="Estadísticas diarias de un mes para una sala",
     *     description="Devuelve las estadísticas de ingresos y gastos por día del mes seleccionado para la sala indicada, incluyendo acumulados.",
     *     tags={"Stats"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
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
    *             @OA\Property(property="salaId", type="integer"),
    *             @OA\Property(
    *                 property="dias",
    *                 type="object",
    *                 example={
    *                     "04-01-2025"={
    *                         "ingresos"=100,
    *                         "gastos"=50,
    *                         "acumulado_ingresos"=100,
    *                         "acumulado_gastos"=50
    *                     },
    *                     "05-01-2025"={
    *                         "ingresos"=200,
    *                         "gastos"=80,
    *                         "acumulado_ingresos"=300,
    *                         "acumulado_gastos"=130
    *                     },
    *                     "06-01-2025"={
    *                         "ingresos"=150,
    *                         "gastos"=60,
    *                         "acumulado_ingresos"=450,
    *                         "acumulado_gastos"=190
    *                     }
    *                 }
    *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="message", type="string", example="No estás autorizado para acceder a las estadísticas de esta sala.")
     *         )
     *     )
     * )
     */
    public function generalMesSelected()
    {
    }

    /**
     * @OA\Get(
     *     path="/api/stats/last12months/{salaId}",
     *     summary="Estadísticas mensuales de los últimos 12 meses para una sala",
     *     description="Devuelve las estadísticas de ingresos y gastos por mes de los últimos 12 meses para la sala indicada, incluyendo acumulados.",
     *     tags={"Stats"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
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
     *             @OA\Property(property="salaId", type="integer"),
     *             @OA\Property(
    *                 property="meses",
    *                 type="object",
    *                 example={
    *                     "01-2025"={
    *                         "ingresos"=1000,
    *                         "gastos"=500,
    *                         "acumulado_ingresos"=1000,
    *                         "acumulado_gastos"=500
    *                     },
    *                     "02-2025"={
    *                         "ingresos"=1200,
    *                         "gastos"=600,
    *                         "acumulado_ingresos"=2200,
    *                         "acumulado_gastos"=1100
    *                     },
    *                     "03-2025"={
    *                         "ingresos"=900,
    *                         "gastos"=400,
    *                         "acumulado_ingresos"=3100,
    *                         "acumulado_gastos"=1500
    *                     }
    *                 }
    *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="message", type="string", example="No estás autorizado para acceder a las estadísticas de esta sala.")
     *         )
     *     )
     * )
     */
    public function generalLast12Months()
    {
    }
}
