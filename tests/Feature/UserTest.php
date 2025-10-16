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

/**
 * Class UserTest
 * Comprobaciones de llamadas a la API de usuarios
 * Solo verificamos los codigos de respuesta de las llamadas
 * @author Lluís Ferrater
 * @version 1.0
 */
class UserTest extends TestCase
{

    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
    }

    /**
     * Test de login de un usuario correcto.
     * Comproba que el usuario se logea correctamente i recivimos una respuesta status 200
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_logear_usuario_correcto(): void
    {
        $response = $this->postJson('api/users/login', [
            'email' => 'user@user.com',
            'password' => 'user123'
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test de login de un usuario incorrecto.
     * Comproba que el usuario no se logea correctamente i recivimos una respuesta status 401
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_logear_usuario_incorrecto(): void
    {
        $response = $this->postJson('api/users/login', [
            'email' => 'noExistente@user.com',
            'password' => 'user1234'
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test de login de un usuario sin password.
     * Comproba que el usuario no se logea correctamente i recivimos una respuesta status 422
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_logear_usuario_sin_password(): void
    {
        $response = $this->postJson('api/users/login', [
            'email' => 'user@user.com',
            'password' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test de registro de un usuario repetido.
     * Comproba que el usuario no se registra correctamente i recivimos una respuesta status 422
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_egistrar_usuario_repetido(): void
    {
        $response = $this->postJson('api/users', [
            'email' => 'user@user.com',
            'password' => 'user123'
        ]);
        
        $response->assertStatus(422);
    }

    public function test_registrar_usuario_con_pasword_corto(): void
    {
        $response = $this->postJson('api/users', [
            'email' => 'usernuevo@user.com',
            'password' => 'us'
        ]);
        
        $response->assertStatus(422);
    }

}
