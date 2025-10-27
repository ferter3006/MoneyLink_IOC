<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Sala;
use App\Models\User;
use App\Models\UserSalaRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder de roles de usuarios en salas
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: Para datos de prueba
 */
class UserSalaRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $salas = Sala::all();
        $roles = Role::all();

        // Generar combinaciones únicas sin duplicar
        $combinations = collect();

        foreach ($users as $user) {
            $availableSalas = $salas->shuffle()->take(rand(1, min(3, $salas->count()))); // cada user 1–3 salas
            foreach ($availableSalas as $sala) {
                $combinations->push([
                    'user_id' => $user->id,
                    'sala_id' => $sala->id,
                    'role_id' => $roles->random()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Insert masivo (eficiente)
        UserSalaRole::insert($combinations->toArray());
    }
}
