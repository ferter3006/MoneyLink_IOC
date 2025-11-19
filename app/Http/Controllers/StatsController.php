<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stats\GeneralGetterStatsRequest;
use App\Models\Sala;
use App\Models\Tiquet;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function general(GeneralGetterStatsRequest $request, $salaId, $m)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');

        // Calculo mes deseado 
        $fecha = now()->addMonths((int) $m);
        $inicioMes = $fecha->copy()->startOfMonth();
        $finMes = $fecha->copy()->endOfMonth();

        // Obtener todos los tiquets de la sala en el mes actual
        $tiquets = Tiquet::where('sala_id', $salaId)
            ->whereBetween('created_at', [$inicioMes, $finMes])
            ->get();

        // Inicializar array de días del mes
        $diasDelMes = [];
        $diasEnMes = $fecha->daysInMonth;
        $acumuladoIngresos = 0;
        $acumuladoGastos = 0;

        // Preprocesar tiquets por día
        $tiquetsPorDia = [];
        foreach ($tiquets as $tiquet) {
            $diaTiquet = $tiquet->created_at->format('d-m-Y');
            if (!isset($tiquetsPorDia[$diaTiquet])) {
                $tiquetsPorDia[$diaTiquet] = [ 'ingresos' => 0, 'gastos' => 0 ];
            }
            if ($tiquet->es_ingreso) {
                $tiquetsPorDia[$diaTiquet]['ingresos'] += $tiquet->amount;
            } else {
                $tiquetsPorDia[$diaTiquet]['gastos'] += $tiquet->amount;
            }
        }

        // Construir array de días con acumulados
        for ($dia = 1; $dia <= $diasEnMes; $dia++) {
            $fechaDia = $fecha->copy()->day($dia)->format('d-m-Y');
            $ingresos = isset($tiquetsPorDia[$fechaDia]) ? $tiquetsPorDia[$fechaDia]['ingresos'] : 0;
            $gastos = isset($tiquetsPorDia[$fechaDia]) ? $tiquetsPorDia[$fechaDia]['gastos'] : 0;
            $acumuladoIngresos += $ingresos;
            $acumuladoGastos += $gastos;
            $diasDelMes[$fechaDia] = [
                'ingresos' => round($ingresos, 2),
                'gastos' => round($gastos, 2),
                'acumulado_ingresos' => round($acumuladoIngresos, 2),
                'acumulado_gastos' => round($acumuladoGastos, 2)
            ];
        }

        // Respuesta con los datos por día
        return response()->json([
            'salaId' => $salaId,
            'dias' => $diasDelMes,
        ]);
    }
}
