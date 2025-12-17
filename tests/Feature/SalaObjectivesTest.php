<?php

namespace Tests\Feature;

use App\Models\UserSalaRole;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SalaSeeder;
use Database\Seeders\UserSalaRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Sala;
use App\Models\SalaObjective;

class SalaObjectivesTest extends TestCase
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

    // funciona para autenticar y obtener token de un usuario (user@user.com)
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
     * Test de creación de un objetivo de sala.
     * Comprueba que se puede crear un objetivo de sala correctamente si se es admin.
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_create_a_sala_objective_on_sala_where_user_is_admin()
    {
        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // user
        $user = User::where('email', 'user@user.com')->first();

        // Obtenemos id de una sala que sea admin
        $sala_Admin = UserSalaRole::where('user_id', $user->id)
            ->where('role_id', 1)
            ->first();

        if (!$sala_Admin) {
            $this->markTestSkipped('No se encontró una sala donde el usuario sea admin para realizar el test. (vuelve a ejecutar el test)');
            return;
        }

        $sala_id_Admin = $sala_Admin->sala_id;

        // Hacer una solicitud autenticada para crear un objetivo de sala en una sala donde es admin
        // hacemos post a /api/sala_objectives/{salaId}
        $objectiveData = [
            'amount' => 1000,
        ];

        $response = $this->postJson('/api/sala_objectives/' . $sala_id_Admin, $objectiveData, [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

    }

    /**
     * Test de creación de un objetivo de sala.
     * Comprueba que no se puede crear un objetivo de sala en una sala donde el usuario no es admin.
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_create_a_sala_objective_on_sala_where_user_is_not_admin()
    {
        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // user
        $user = User::where('email', 'user@user.com')->first();

        // Obtenemos id de una sala que no sea admin
        $sala_NotAdmin = UserSalaRole::where('user_id', $user->id)
            ->where('role_id', 2)
            ->first();

        if (!$sala_NotAdmin) {
            $this->markTestSkipped('No se encontró una sala donde el usuario no sea admin para realizar el test. (vuelve a ejecutar el test)');
            return;
        }

        $sala_id_NotAdmin = $sala_NotAdmin->sala_id;

        // Hacer una solicitud autenticada para crear un objetivo de sala en una sala donde es admin
        // hacemos post a /api/sala_objectives/{salaId}
        $objectiveData = [
            'amount' => 1000,
        ];

        $response = $this->postJson('/api/sala_objectives/' . $sala_id_NotAdmin, $objectiveData, [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Comprobamos que la respuesta sea 403 Forbidden
        $response->assertStatus(403); // Forbidden
    }

    /**
     * Test de obtención de objetivos de sala.
     * Comprueba que se pueden obtener los objetivos de sala correctamente si se esta en ella.
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_get_sala_objectives_on_sala_where_user_is_in_sala()
    {
        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // get salas en api/salas/me
        $response = $this->get('/api/salas/me', [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

        $responseData = json_decode($response->getContent(), true);
        $salas = $responseData['salas'] ?? [];

        if (count($salas) === 0) {
            $this->markTestSkipped('No se encontró una sala para realizar el test. (vuelve a ejecutar el test)');
            return;
        }

        $sala_id = $salas[0]['sala_id'];

        // Hacer una solicitud autenticada para obtener los objetivos de sala
        $response = $this->getJson('/api/sala_objectives/' . $sala_id, [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);

    }

    /**
     * Test de obtención de objetivos de sala.
     * Comprueba que no se pueden obtener los objetivos de sala si no se esta en ella.
     * @author Lluís Ferrater
     * @version 1.0
     */

    public function test_get_sala_objectives_on_sala_where_user_is_not_in_sala()
    {
        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // User
        $user = User::where('email', 'user@user.com')->first();

        // Obtenemos id de una sala donde el usuario no está
        $userSalaIds = UserSalaRole::where('user_id', $user->id)->pluck('sala_id');
        $salaSinElUsuario = Sala::whereNotIn('id', $userSalaIds)->first()?->id;


        // Hacer una solicitud autenticada para obtener los objetivos de sala
        $response = $this->getJson('/api/sala_objectives/' . $salaSinElUsuario, [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(403); // Forbidden
    }
}
