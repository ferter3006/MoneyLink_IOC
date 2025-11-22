<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Models\Tiquet;
use App\Services\SalaService;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    public function informeSalaMes($salaId, $m)
    {
        // Lógica para generar el informe de la sala para el mes especificado
        // Calculo mes deseado
        $fecha = now()->addMonths((int) $m);
        $mes = $fecha->month;
        $año = $fecha->year;
        $inicioMes = $fecha->copy()->startOfMonth();
        $finMes = $fecha->copy()->endOfMonth();


        $sala = SalaService::getOneSala($salaId, null, $inicioMes, $finMes);

        foreach ($sala->tiquets as $tiquet) {
            // Agregar el user-name a cada tiquet desde el user_id que ya teiene                        
            $usuario = collect($sala->usuarios)
                ->firstWhere('id', $tiquet['user_id']);
            $tiquet->user_name = $usuario ? $usuario['name'] : 'Desconocido';
            // Agregar la categoría nombre desde category_id
            $tiquet->category_name = $tiquet->category ? $tiquet->category->name : 'Sin categoría';

        }

        // Realizamos la suma de ingresos y gastos
        $ingresos = collect($sala->tiquets)->where('es_ingreso', true)->sum('amount');
        $gastos = collect($sala->tiquets)->where('es_ingreso', false)->sum('amount');
        $balance = $ingresos - $gastos;

        $sala->ingresos = $ingresos;
        $sala->gastos = $gastos;
        $sala->balance = $balance;

        // Añadimos el objetivo del mes si existe
        $objetivo = collect($sala->salaObjectives)->first();
        $sala->objetivo = $objetivo ? $objetivo->amount : 0;

        return view('informeSalaMesActualView', [
            'sala' => $sala,
            'mes' => $mes,
            'año' => $año,
            'inicioMes' => $inicioMes,
            'finMes' => $finMes,
        ]);
    }
}
