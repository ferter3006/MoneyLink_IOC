<?php

namespace Database\Factories;

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
    {
        return [
            'user_id' => fake()->numberBetween(1, 3),
            'sala_id' => fake()->numberBetween(1, 3),
            'role_id' => fake()->numberBetween(1, 3)
        ];
    }
}
