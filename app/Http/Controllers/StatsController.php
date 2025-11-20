<?php

namespace App\Http\Controllers;

use App\Http\Requests\Stats\GeneralGetterStatsRequest;
use App\Http\Requests\Stats\GeneralLast12MonthsRequests;
use App\Models\Sala;
use App\Models\Tiquet;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function generalLast12Months(GeneralLast12MonthsRequests $request, $salaId)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');

        $fechaActual = now();
        $meses = [];
        $acumuladoIngresos = 0;
        $acumuladoGastos = 0;

        // Obtener todos los tiquets de la sala en los últimos 12 meses
        $inicio = $fechaActual->copy()->subMonths(11)->startOfMonth();
        $fin = $fechaActual->copy()->endOfMonth();
        $tiquets = Tiquet::where('sala_id', $salaId)
            ->whereBetween('created_at', [$inicio, $fin])
            ->get();

        // Preprocesar tiquets por mes
        $tiquetsPorMes = [];
        foreach ($tiquets as $tiquet) {
            $mesTiquet = $tiquet->created_at->format('m-Y');
            if (!isset($tiquetsPorMes[$mesTiquet])) {
                $tiquetsPorMes[$mesTiquet] = ['ingresos' => 0, 'gastos' => 0];
            }
            if ($tiquet->es_ingreso) {
                $tiquetsPorMes[$mesTiquet]['ingresos'] += $tiquet->amount;
            } else {
                $tiquetsPorMes[$mesTiquet]['gastos'] += $tiquet->amount;
            }
        }

        // Construir array de meses con acumulados
        for ($i = 0; $i < 12; $i++) {
            $fechaMes = $fechaActual->copy()->subMonths(11 - $i);
            $mesKey = $fechaMes->format('m-Y');
            $ingresos = isset($tiquetsPorMes[$mesKey]) ? $tiquetsPorMes[$mesKey]['ingresos'] : 0;
            $gastos = isset($tiquetsPorMes[$mesKey]) ? $tiquetsPorMes[$mesKey]['gastos'] : 0;
            $acumuladoIngresos += $ingresos;
            $acumuladoGastos += $gastos;
            $meses[$mesKey] = [
                'ingresos' => round($ingresos, 2),
                'gastos' => round($gastos, 2),
                'acumulado_ingresos' => round($acumuladoIngresos, 2),
                'acumulado_gastos' => round($acumuladoGastos, 2)
            ];
        }

        return response()->json([
            'salaId' => $salaId,
            'meses' => $meses,
        ]);
    }
    public function generalMesSelected(GeneralGetterStatsRequest $request, $salaId, $m)
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
                $tiquetsPorDia[$diaTiquet] = ['ingresos' => 0, 'gastos' => 0];
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
