<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder de la base de datos
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: Para datos de prueba
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            SalaSeeder::class,
            UserSalaRoleSeeder::class,
            CategorySeeder::class,
            TiquetSeeder::class,
            TiquetsRecurrentesSeeder::class
        ]);
    }
}
