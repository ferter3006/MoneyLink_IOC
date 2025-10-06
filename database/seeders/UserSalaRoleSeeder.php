<?php

namespace Database\Seeders;

use App\Models\UserSalaRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSalaRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserSalaRole::factory()->create([
            'user_id' => 2,
            'sala_id' => 1,
            'role_id' => 1
        ]);

        UserSalaRole::factory()->create([
            'user_id' => 3,
            'sala_id' => 2,
            'role_id' => 1
        ]);

        UserSalaRole::factory()->create([
            'user_id' => 4,
            'sala_id' => 3,
            'role_id' => 1
        ]);

        UserSalaRole::factory()->create([
            'user_id' => 2,
            'sala_id' => 2,
            'role_id' => 2
        ]);

        UserSalaRole::factory()->create([
            'user_id' => 2,
            'sala_id' => 3,
            'role_id' => 2
        ]);
    }
}
