<?php

namespace Tests\Feature;

use App\Models\Tiquet;
use App\Models\User;
use App\Models\UserSalaRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TiquetTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Ejecutar las migraciones antes de cada prueba
        $this->artisan('migrate:fresh --seed');
    }

    private function authenticateAndGetToken()
    {
        $loginResponse = $this->post('/api/users/login', [
            'email' => "user@user.com",
            'password' => "user123",
        ], [
            'Accept' => 'application/json',
        ]);

        $loginData = json_decode($loginResponse->getContent(), true);
        $token = $loginData['token'] ?? null;
        $userId = $loginData['user']['id'] ?? null;
        $this->assertNotEmpty($token, 'No se obtuvo el token de login');
        return [$token, $userId];
    }

    /**
     * Test para comprobar que un usuario puede obtener los detalles de un tiquet que le pertenece
     */

    public function test_user_get_tiquet_details(): void
    {
        // Autentica el usuario y obtiene el token y el id del usuario
        [$token, $userId] = $this->authenticateAndGetToken();

        $userTiquets = Tiquet::where('user_id', $userId)->get();

        if ($userTiquets->isEmpty()) {
            $this->markTestSkipped('El usuario no tiene tiquets para probar. Vuelve a probar (Seeders random)');
        }

        $response = $this->get('/api/tiquets/' . $userTiquets->first()->id, [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(Response::HTTP_OK);
    }

    // Test para comprobar que un usuario no puede obtener los detalles de un tiquet que no le pertenece
    public function test_user_get_tiquet_details_not_owner(): void
    {
        [$token, $userId] = $this->authenticateAndGetToken();

        $userTiquets = Tiquet::where('user_id', '!=', $userId)->first();

        $response = $this->get('/api/tiquets/' . $userTiquets->id, [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Verificar que la respuesta sea forbidden
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    // Test para comprobar que un usuario puede crear un tiquet en una sala a la que pertenece
    public function test_user_create_tiquet(): void
    {
        [$token, $userId] = $this->authenticateAndGetToken();

        $salaId = User::where('email', 'user@user.com')->first()->userSalaRoles()->first()->sala_id;

        if (!$salaId) {
            $this->markTestSkipped('El usuario no pertenece a ninguna sala. Vuelve a probar (Seeders random)');
        }

        $response = $this->post('/api/tiquets', [
            'sala_id' => $salaId,
            'category_id' => 1,
            'amount' => 100,
            'es_ingreso' => true,
            'description' => 'Tiquet de prueba',
        ], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(Response::HTTP_OK);
    }

    // Test para comprobar que un usuario no puede crear un tiquet en una sala a la que no pertenece
    public function test_user_create_tiquet_not_in_sala(): void
    {
        [$token, $userId] = $this->authenticateAndGetToken();

        $salaId = UserSalaRole::where('user_id', '!=', $userId)->first()->sala_id;        

        $response = $this->post('/api/tiquets', [
            'sala_id' => $salaId,
            'category_id' => 1,
            'amount' => 100,
            'es_ingreso' => true,
            'description' => 'Tiquet de prueba',
        ], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);
        
        // Verificar que la respuesta sea unprocessable entity (error de validación)
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
