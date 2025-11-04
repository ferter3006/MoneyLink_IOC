<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tiquet>
 */
class TiquetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $numUsers = User::count();
        $numSalas = Sala::count();
        $numCategorias = Category::count();

        return [
            'user_id' => fake()->numberBetween(1, $numUsers),
            'sala_id' => fake()->numberBetween(1, $numSalas),
            'category_id' => fake()->numberBetween(1, $numCategorias),
            'es_ingreso' => fake()->boolean(),
            'description' => fake()->sentence(),
            'amount' => fake()->randomFloat(2, 1, 2000),
            'created_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
