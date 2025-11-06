<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\CacheTokenService;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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

    // Refrescamos la base de datos de prueba
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        // Cargamos los seeders con los datos de prueba
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
     * Comproba que el usuario no se logea (por ser inexistente) y recivimos una respuesta status 401
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_logear_usuario_inexistente(): void
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
    public function test_registrar_usuario_repetido(): void
    {
        $response = $this->postJson('api/users', [
            'email' => 'user@user.com',
            'password' => 'user123'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test de registro de un usuario con password corto.
     * Comproba que el usuario no se registra correctamente i recivimos una respuesta status 422
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_registrar_usuario_con_pasword_corto(): void
    {
        $response = $this->postJson('api/users', [
            'email' => 'usernuevo@user.com',
            'password' => 'us'
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test de registro de un usuario correcto.
     * Comproba que el usuario se registra correctamente y recivimos una respuesta status 200
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_registrar_un_usuario_correctamente(): void
    {
        // Realizamos la petición POST con los datos de prueba
        // Nota: No se le pasa el role_id, por que por defecto es USER
        $response = $this->postJson('api/users', [
            'email' => 'usernuevo@user.com',
            'password' => 'User123!!!',
            'name' => 'User Nuevo'
        ]);

        $response->assertStatus(200);
    }

    public function test_login_api_externa()
    {
        $url = 'https://ioc.ferter.es/api/users/login';
        $requestBody = [
            'email' => 'user@user.com',
            'password' => 'user123'
        ];

        $response = Http::withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($url, $requestBody);

        // Verificar status
        $this->assertEquals(200, $response->status());

        // Obtener datos
        $data = $response->json();
        print_r($data);

        // Verificaciones adicionales
        $this->assertArrayHasKey('token', $data);
        $this->assertArrayHasKey('user', $data);
    }
}
