<?php

namespace Database\Seeders;

use App\Models\Sala;
use Illuminate\Database\Seeder;

/**
 * Seeder de salas
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: Para datos de prueba
 */
class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sala::factory()->create([
            'user_id' => 3,
            'name' => 'Economia Sanchez'
        ]);

        Sala::factory()->create([
            'user_id' => 4,
            'name' => 'Sala de Luis'
        ]);

        Sala::factory(8)->create();
    }
}
