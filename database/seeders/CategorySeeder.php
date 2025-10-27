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
        $categorias = [
            'Alquiler o Hipoteca',
            'Comunidad / mantenimiento',
            'Suministro Agua',
            'Suministro Luz',
            'Suministro Gas',
            'Internet / Telefono',
            'Seguro del hogar',
            'Impuesto de vivienda',
            'Supermercado',
            'Panaderia',
            'Comidas fuera de casa',
            'Productos de limpieza',
            'Mascotas',
            'Combustible',
            'Transporte publico',
            'Mantenimiento del vehiculo',
            'Impuesto del vehiculo',
            'Aparcamiento',
            'Seguro medico',
            'Medicamentos',
            'Gimnasio / Deporte',
            'Ropa / Calzado',
            'Educacion / formacion',
            'Ocio / Cultura',
            'Regalos',
            'Donaciones',
            'Gastos imprevistos',
            'Intereses o prestamos',
            'Ahorro programado',
            'Otros'
        ];

        foreach ($categorias as $categoria) {
            Category::create([
                'name' => $categoria
            ]);
        }
    }
}
