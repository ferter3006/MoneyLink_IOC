<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Seeder de roles
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: Para datos de prueba
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::factory()->create([
            'id' => 1,
            'name' => 'admin',
        ]);

        Role::factory()->create([
            'id' => 2,
            'name' => 'user',
        ]);
    }
}
