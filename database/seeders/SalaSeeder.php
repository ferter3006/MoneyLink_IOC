<?php

namespace Database\Seeders;

use App\Models\Sala;
use Illuminate\Database\Seeder;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sala::factory()->create([
            'owner' => 2,
            'name' => 'Economia Sanchez'
        ]);

        Sala::factory()->create([
            'owner' => 3,
            'name' => 'Sala de Luis'
        ]);
    }
}
