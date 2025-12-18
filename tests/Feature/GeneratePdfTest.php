<?php

namespace Tests\Feature;

use Database\Seeders\RoleSeeder;
use Database\Seeders\SalaSeeder;
use Database\Seeders\UserSalaRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserSalaRole;

class GeneratePdfTest extends TestCase
{
    use RefreshDatabase;

    // Seedeamos la base de datos de pruebas antes de cada test
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');        
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(SalaSeeder::class);
        $this->seed(UserSalaRoleSeeder::class);
    }

    // funcion para autenticar y obtener token de un usuario (user@user.com)
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
        $this->assertNotEmpty($token, 'No se obtuvo el token de login');
        return $token;
    }

    /**
     * Test de descarga de informe en PDF.
     * Comprueba que se puede descargar el informe en PDF de una sala correctamente.
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_download_sala_informe_pdf_success()
    {
        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // user
        $user = User::where('email', 'user@user.com')->first();

        // Obtenemos id de una sala donde el usuario esta
        $sala = UserSalaRole::where('user_id', $user->id)->first();

        if (!$sala) {
            $this->markTestSkipped('No se encontró una sala para realizar el test. (vuelve a ejecutar el test)');
            return;
        }

        $salaId = $sala->sala_id;
        $mes = 0; // mes actual

        // Hacemos la solicitud para descargar el PDF
        $response = $this->getJson("/api/informe/{$salaId}/{$mes}/download", [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Test de descarga de informe en PDF sin autenticación.
     * Comprueba que no se puede descargar el informe sin token de autenticación.
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_download_sala_informe_pdf_without_authentication()
    {
        $salaId = 1;
        $mes = 0;

        // Hacemos la solicitud sin token
        $response = $this->getJson("/api/informe/{$salaId}/{$mes}/download", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401); // Unauthorized
    }

    /**
     * Test de descarga de informe en PDF con sala inexistente.
     * Comprueba que devuelve 403 al intentar descargar un informe de una sala que no existe.
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_download_sala_informe_pdf_invalid_sala_id()
    {
        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        $salaId = 99999; // ID de sala inexistente
        $mes = 0;

        // Hacemos la solicitud con una sala inexistente
        $response = $this->getJson("/api/informe/{$salaId}/{$mes}/download", [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test de descarga de informe en PDF de una sala donde el usuario no está.
     * Comprueba que no se puede descargar el informe de una sala donde el usuario no tiene acceso.
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_download_sala_informe_pdf_forbidden_sala()
    {
        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // user
        $user = User::where('email', 'user@user.com')->first();

        // Obtenemos todas las salas donde el usuario esta
        $userSalaIds = UserSalaRole::where('user_id', $user->id)->pluck('sala_id');

        // Buscamos una sala donde el usuario NO está
        $forbiddenSala = \App\Models\Sala::whereNotIn('id', $userSalaIds)->first();

        if (!$forbiddenSala) {
            $this->markTestSkipped('No se encontró una sala donde el usuario no tenga acceso. (vuelve a ejecutar el test)');
            return;
        }

        $salaId = $forbiddenSala->id;
        $mes = 0;

        // Hacemos la solicitud a una sala donde no tenemos acceso
        $response = $this->getJson("/api/informe/{$salaId}/{$mes}/download", [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(403); // Forbidden
    }
}
