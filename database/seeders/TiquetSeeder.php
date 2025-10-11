<?php

namespace Database\Seeders;

use App\Models\Tiquet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'tipo' => 1,
            'description' => 'Sueldo',
            'amount' => 1800
        ]);

        Tiquet::create([
            'user_id' => 2,
            'sala_id' => 1,
            'category_id' => 2,
            'tipo' => 0,
            'description' => 'Compra Lidl',
            'amount' => 87
        ]);

        Tiquet::create([
            'user_id' => 2,
            'sala_id' => 1,
            'category_id' => 3,
            'tipo' => 0,
            'description' => 'Bono bus',
            'amount' => 15            
        ]);
    }
}
