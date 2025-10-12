<?php

namespace App\Jobs;

use App\Models\PlantillaTiquet;
use App\Models\Tiquet;
use Illuminate\Container\Attributes\Log as AttributesLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isNull;

class VerifyTiquetsRecurrentes implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    // Job que verifica si los tiquets recurrentes deben activarse este mes
    // Si es que si, se crea una copia del tiquet recurrente en la tabla tiquets
    public function handle(): void
    {
        $tiquetsRecurrentes = PlantillaTiquet::where('recurrencia_es_mensual', true)->get();


        foreach ($tiquetsRecurrentes as $tiquet) {
            Log::info('Verificando tiquet recurrente ' . $tiquet->id);

            $ultima = $tiquet->ultima_activacion;

            // Activar si nunca se ha activado o si la última activación no es del mes actual (por que sera un mes anterior)
            if (is_null($ultima) || !$ultima->isSameMonth(now())) {
                Log::info('El tiquet recurrente ' . $tiquet->id . ' aun falta activarse este mes');

                // Activar el tiquet si el dia de activacion es el dia actual
                if ($tiquet->recurrencia_dia_activacion == now()->day) {
                    // Crear el tiquet con los datos de la plantilla de tiquet recurrente
                    Tiquet::create([
                        'user_id' => $tiquet->user_id,
                        'sala_id' => $tiquet->sala_id,
                        'category_id' => $tiquet->category_id,
                        'es_ingreso' => $tiquet->es_ingreso,
                        'description' => $tiquet->description,
                        'amount' => $tiquet->amount
                    ]);

                    // Actualizar la última activación
                    $tiquet->ultima_activacion = now();
                    $tiquet->save();
                }
            } else {
                Log::info('El tiquet recurrente ' . $tiquet->id . ' ya se activó este mes');
            }
        }
    }
}
