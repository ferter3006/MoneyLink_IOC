<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder de usuarios
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: Para datos de prueba
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Señor Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Señor Pepe (admin)',
            'email' => 'pepe@pepe.com',
            'password' => Hash::make('pepe123'),
            'role_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'Fran (user)',
            'email' => 'user@user.com',
            'password' => Hash::make('user123'),
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'Luis (user)',
            'email' => 'luis@luis.com',
            'password' => Hash::make('luis123'),
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'Eduardo (user)',
            'email' => 'eduardo@eduardo.com',
            'password' => Hash::make('eduardo123'),
            'role_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'Paco (user)',
            'email' => 'paco@paco.com',
            'password' => Hash::make('paco123'),
            'role_id' => 2,
        ]);

        User::factory(10)->create();
    }
}
