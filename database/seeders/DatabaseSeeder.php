<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Log::info('Seeding database...');
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            SalaSeeder::class,
            UserSalaRoleSeeder::class,
            CategorySeeder::class,
            TiquetSeeder::class,
            PlantillaTiquetSeeder::class
        ]);
    }
}
