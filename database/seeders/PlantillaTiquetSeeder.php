<?php

namespace Database\Seeders;

use App\Jobs\VerifyTiquetsRecurrentes;
use App\Models\PlantillaTiquet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlantillaTiquetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlantillaTiquet::create([
            'user_id' => 2,
            'sala_id' => 1,
            'category_id' => 1,
            'es_ingreso' => 1,
            'description' => 'Sueldo',
            'amount' => 1300,
            'recurrencia_es_mensual' => 1,
            'recurrencia_dia_activacion' => 1,
            'ultima_activacion' => null
        ]);

        VerifyTiquetsRecurrentes::dispatch();

    }
}
