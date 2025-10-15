<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\CacheTokenService;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
    }

    // Test de longin de un usuario correcto
    public function test_logear_usuario_correcto(): void
    {
        $response = $this->postJson('api/users/login', [
            'email' => 'user@user.com',
            'password' => 'user123'
        ]);

        $response->assertStatus(200);
    }

    // Test de login de un usuario inexistente
    public function test_logear_usuario_incorrecto(): void
    {
        $response = $this->postJson('api/users/login', [
            'email' => 'noExistente@user.com',
            'password' => 'user1234'
        ]);

        $response->assertStatus(401);
    }

    // Test de login sin enviar password
    public function test_logear_usuario_sin_password(): void
    {
        $response = $this->postJson('api/users/login', [
            'email' => 'user@user.com',
            'password' => ''
        ]);

        $response->assertStatus(422);
    }

}
