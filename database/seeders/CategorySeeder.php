<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder de categorias
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: Para datos de prueba
 */
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Sueldo',
        ]);

        Category::create([
            'name' => 'Comida',
        ])
        ;

        Category::create([
            'name' => 'Transporte',
        ]);

        Category::create([
            'name' => 'Otros',
        ]);
    }
}
