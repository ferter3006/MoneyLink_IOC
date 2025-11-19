<?php

namespace Database\Seeders;

use App\Models\Tiquet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder de tiquets
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: Para datos de prueba
 */
class TiquetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todas las salas y usuarios
        $salas = \App\Models\Sala::all();
            $users = \App\Models\User::all(); // This line remains unchanged
        $categoryIngreso = \App\Models\Category::where('name', 'Sueldo')->first() ?? 1;
        $categoryGasto = \App\Models\Category::where('name', 'Gasto')->first() ?? 2;

        // Configuración de meses a crear
        $meses = 3; // Cambia esto si quieres más meses
        $diasHoy = now();

        foreach ($salas as $sala) {
            $usersSala = \App\Models\UserSalaRole::where('sala_id', $sala->id)->pluck('user_id');
            if ($usersSala->isEmpty()) continue;
            for ($m = 0; $m < $meses; $m++) {
                $fechaMes = $diasHoy->copy()->subMonths($m);
                $inicioMes = $fechaMes->copy()->startOfMonth();
                $finMes = $fechaMes->copy()->endOfMonth();
                $diasEnMes = $fechaMes->daysInMonth;

                // Ingreso mensual único
                Tiquet::create([
                    'user_id' => $usersSala->random(),
                    'sala_id' => $sala->id,
                    'category_id' => is_object($categoryIngreso) ? $categoryIngreso->id : $categoryIngreso,
                    'es_ingreso' => 1,
                    'description' => 'Sueldo mensual',
                    'amount' => rand(1700, 2400),
                    'created_at' => $inicioMes->copy()->addDays(rand(0,2)),
                ]);

                // Gastos ficticios por día
                for ($dia = 1; $dia <= $diasEnMes; $dia++) {
                    $fechaDia = $inicioMes->copy()->day($dia);
                    $numGastos = rand(0,2);
                    for ($g = 0; $g < $numGastos; $g++) {
                        Tiquet::create([
                            'user_id' => $usersSala->random(),
                            'sala_id' => $sala->id,
                            'category_id' => is_object($categoryGasto) ? $categoryGasto->id : $categoryGasto,
                            'es_ingreso' => 0,
                            'description' => 'Gasto ficticio',
                            'amount' => rand(5, 120),
                            'created_at' => $fechaDia->copy()->addMinutes(rand(0, 1439)),
                        ]);
                    }
                }
            }
        }
        // ...existing code...
    }
}
