<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Services\CacheTokenService;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RutasPrivadasTest extends TestCase
{

    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
    }

    // Test de peticón a una ruta privada sin token
    public function test_get_salas_sin_token(): void
    {
        $response = $this->get('api/salas/me');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    // Test de peticón a una ruta privada con token
    public function test_get_salas_con_token(): void
    {
        $user = User::all()->first();
        $cacherSevice = new CacheTokenService();
        $token = $cacherSevice->crearTokenParaUsuario($user);

        $response = $this->get('api/salas/me', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    // Test de peticón a una ruta restringida ADMIN con un token de USER
    public function test_get_roles_con_token_user(): void
    {
        $role_id = Role::where('name', 'user')->first()->id;
        $user = User::where('role_id', $role_id)->first();

        $cacherSevice = new CacheTokenService();
        $token = $cacherSevice->crearTokenParaUsuario($user);

        $response = $this->get('api/roles', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    // Test de peticón a una ruta restringida ADMIN con un token de ADMIN
    public function test_get_roles_con_token_admin(): void
    {
        $role_id = Role::where('name', 'admin')->first()->id;
        $user = User::where('role_id', $role_id)->first();

        $cacherSevice = new CacheTokenService();
        $token = $cacherSevice->crearTokenParaUsuario($user);

        $response = $this->get('api/roles', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
