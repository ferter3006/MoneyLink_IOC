<?php

namespace Database\Seeders;

use App\Models\TiquetRecurrente;
use Illuminate\Database\Seeder;

class TiquetsRecurrentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TiquetRecurrente::create([
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
    }
}
