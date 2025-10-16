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
        Tiquet::create([
            'user_id' => 2,
            'sala_id' => 1,
            'category_id' => 1,
            'es_ingreso' => 1,
            'description' => 'Sueldo',
            'amount' => 1800,
            'created_at' => now()->addMonths(-1)
        ]);

        Tiquet::create([
            'user_id' => 4,
            'sala_id' => 1,
            'category_id' => 1,
            'es_ingreso' => 1,
            'description' => 'Sueldo',
            'amount' => 1800,            
        ]);

        Tiquet::create([
            'user_id' => 2,
            'sala_id' => 1,
            'category_id' => 2,
            'es_ingreso' => 0,
            'description' => 'Compra Lidl',
            'amount' => 87
        ]);

        Tiquet::create([
            'user_id' => 4,
            'sala_id' => 1,
            'category_id' => 2,
            'es_ingreso' => 0,
            'description' => 'Compra mercadona',
            'amount' => 34.59
        ]);

        Tiquet::create([
            'user_id' => 2,
            'sala_id' => 1,
            'category_id' => 3,
            'es_ingreso' => 0,
            'description' => 'Bono bus',
            'amount' => 15
        ]);
    }
}
