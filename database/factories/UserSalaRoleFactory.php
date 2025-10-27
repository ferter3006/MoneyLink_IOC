<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Sala;
use App\Models\User;
use App\Models\UserSalaRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSalaRole>
 */
class UserSalaRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { {
            return [
                'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
                'sala_id' => Sala::inRandomOrder()->first()?->id ?? Sala::factory(),
                'role_id' => Role::inRandomOrder()->first()?->id ?? Role::factory(),
            ];
        }
    }
}
