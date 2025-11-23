<?php

namespace App\Docs\Swagger;
class InformeController
{
    /**
     * @OA\Get(
     *     path="/informe/{salaId}/{m}/download",
     *     summary="Descargar informe mensual de una sala en PDF",
     *     description="Descarga el informe mensual de una sala específica en formato PDF.",
     *     tags={"Informe"},
     *     security={{"bearerAuth":{}}},
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
     *         description="Mes del informe (0=actual, 1=anterior, etc.)",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generado correctamente",
     *         @OA\MediaType(
     *             mediaType="application/pdf"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sala o mes no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado (token inválido o no presente)"
     *     )
     * )
     */

    public function downloadPdf()
    {
    }

}
