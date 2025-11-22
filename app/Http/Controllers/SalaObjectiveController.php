<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalaObjectiveResource;
use App\Models\SalaObjective;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalaObjectiveController extends Controller
{
    public function index(Request $request, $salaId, $m)
    {
        $fecha = now()->startOfMonth()->addMonths((int) $m);

        $salaObjective = SalaObjective::where('sala_id', $salaId)
            ->where('date', $fecha)
            ->first();

        $response = [
            'status' => '1',
            'data' => $salaObjective ?
                new SalaObjectiveResource($salaObjective) :
                null
        ];

        if (!$salaObjective) {
            $response['message'] = 'No hay objetivos para este mes';
        }

        return response()->json($response, 200);
    }

    public function index12Months(Request $request, $salaId)
    {
        // Obtener los objetivos de los últimos 12 meses
        $mesActual = now()->startOfMonth();
        $meses = [];
        for ($i = 11; $i >= 0; $i--) {
            $mes = $mesActual->copy()->subMonths($i);
            $meses[$mes->format('m-Y')] = null;
        }

        $salaObjectives = SalaObjective::where('sala_id', $salaId)
            ->whereBetween('date', [
                $mesActual->copy()->subMonths(11),
                $mesActual
            ])
            ->get();

        return response()->json([
            'status' => '1',
            'message' => 'Objetivos de los últimos 12 meses. Si un mes no sale en la lista es que no tiene objetivo asignado.',
            'data' => SalaObjectiveResource::collection($salaObjectives)
        ], 200);
    }

    public function store(Request $request, $salaId)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        $fecha = now()->startOfMonth();

        $salaObjective = SalaObjective::updateOrCreate(
            [
                'sala_id' => $salaId,
                'date' => $fecha,
                'amount' => $request->amount
            ]
        );

        return response()->json([
            'status' => '1',
            'data' => $salaObjective
        ], 200);


    }
}
