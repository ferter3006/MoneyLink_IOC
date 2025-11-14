<?php

namespace Tests\Feature;

use App\Models\Invitacion;
use App\Models\Sala;
use App\Models\User;
use App\Models\UserSalaRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SalaSeeder;
use Database\Seeders\UserSalaRoleSeeder;
use Database\Seeders\UserSeeder;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class InvitacionesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Migrar la base de datos antes de cada prueba
        $this->artisan('migrate:fresh');

        // Seeders
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(SalaSeeder::class);
        $this->seed(UserSalaRoleSeeder::class);
    }

    /**
     * Función auxiliar para autenticar un usuario y obtener su token
     */
    private function authenticateAndGetUserToken($email = "user@user.com", $password = "user123"): array
    {
        $response = $this->post('/api/users/login', [
            'email' => $email,
            'password' => $password,
        ], [
            'Accept' => 'application/json',
        ]);
        $data = json_decode($response->getContent(), true);
        $token = $data['token'] ?? null;
        $userId = User::where('email', $email)->first()->id;
        $this->assertNotEmpty($token, 'No se obtuvo el token de login');
        return [$token, $userId];
    }

    /**
     * Test para listar las invitaciones de un usuario
     * @author Lluis F.
     */

    public function test_get_invitations_received(): void
    {
        $invitacionesEsperadas = 0;
        [$token, $userId] = $this->authenticateAndGetUserToken();

        $response = $this->get('/api/invitaciones/recibidas', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $invitaciones = $response->json('invitaciones');

        // Recuento de invitaciones obtenidas
        $recuentoInvitacionesActuales = count($invitaciones);

        $this->assertEquals($invitacionesEsperadas, $recuentoInvitacionesActuales, "El número de invitaciones recibidas no coincide con el esperado.");

        // Crear una nueva invitación para el usuario autenticado
        Invitacion::create([
            'sala_id' => 1,
            'user_invitado_id' => $userId,
            'user_invitador_id' => 1,
        ]);

        $invitacionesEsperadas = 1;

        // Volver a obtener las invitaciones después de crear una nueva
        $response = $this->get('/api/invitaciones/recibidas', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $invitaciones = $response->json('invitaciones');

        // Recuento de invitaciones obtenidas
        $recuentoInvitacionesActuales = count($invitaciones);

        $this->assertEquals($invitacionesEsperadas, $recuentoInvitacionesActuales, "El número de invitaciones recibidas no coincide con el esperado.");
    }

    /**
     * Test para listar las invitaciones enviadas de un usuario
     * @author Lluis F.
     */
    public function test_get_invitations_sent(): void
    {
        $invitacionesEsperadas = 0;
        [$token, $userId] = $this->authenticateAndGetUserToken();

        $response = $this->get('/api/invitaciones/enviadas', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $invitaciones = $response->json('invitaciones');

        // Recuento de invitaciones obtenidas
        $recuentoInvitacionesActuales = count($invitaciones);

        $this->assertEquals($invitacionesEsperadas, $recuentoInvitacionesActuales, "El número de invitaciones enviadas no coincide con el esperado.");

        // Crear una nueva invitación para el usuario autenticado
        Invitacion::create([
            'sala_id' => 1,
            'user_invitado_id' => 1,
            'user_invitador_id' => $userId,
        ]);

        $invitacionesEsperadas = 1;

        // Volver a obtener las invitaciones luego de crear una nueva
        $response = $this->get('/api/invitaciones/enviadas', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $invitaciones = $response->json('invitaciones');

        // Recuento de invitaciones obtenidas
        $recuentoInvitacionesActuales = count($invitaciones);

        $this->assertEquals($invitacionesEsperadas, $recuentoInvitacionesActuales, "El número de invitaciones enviadas no coincide con el esperado.");

    }

    /**
     * Test para crear una invitación a un usario que no existe
     * @author Lluis F.
     */

    public function test_create_invitation_to_nonexistent_user(): void
    {
        [$token, $userId] = $this->authenticateAndGetUserToken();

        $response = $this->post('/api/invitaciones', [
            'sala_id' => 1,
            'email_invitado' => 'm9HwS@examplew.fake', // Email que no existe
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Test para crear una invitación a un usuario existente a una sala que no me pertenece
     * @author Lluis F.
     */

    public function test_create_invitation_to_existing_user_in_non_owned_room(): void
    {
        [$token, $userId] = $this->authenticateAndGetUserToken();

        $salaNotOwned = UserSalaRole::where('user_id', '!=', $userId)->first();

        $response = $this->post('/api/invitaciones', [
            'sala_id' => $salaNotOwned->sala_id,
            'email_invitado' => 'pepe@pepe.com', // Email que existe
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Test para crear una invitación a un usuario existente a una sala que me pertenece
     * @author Lluis F.
     */

    public function test_create_invitation_to_existing_user_in_owned_room(): void
    {
        [$token, $userId] = $this->authenticateAndGetUserToken();

        // Crear una sala propia via API
        $responseCreateSala = $this->post('/api/salas', [
            'name' => 'zasfD453',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Obtener el ID de la sala creada        
        $salaResponseData = json_decode($responseCreateSala->getContent(), true);
        $salaId = $salaResponseData['sala']['sala_id'];

        // Ahora intentar crear la invitación
        $response = $this->post('/api/invitaciones', [
            'sala_id' => $salaId,
            'email_invitado' => 'pepe@pepe.com', // Email que existe
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(Response::HTTP_OK);

    }

    /**
     * Test para aceptar una invitación a una sala
     * @author Lluis F.
     */

    public function test_accept_invitation_to_room(): void
    {
        // Logueamos con otro usuario para crear sala nueva + invitación
        [$token, $userId] = $this->authenticateAndGetUserToken("pepe@pepe.com", "pepe123");

        // Crear una sala propia via API
        $responseCreateSala = $this->post('/api/salas', [
            'name' => 'zasfD453',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Obtener el ID de la sala creada        
        $salaResponseData = json_decode($responseCreateSala->getContent(), true);
        $salaId = $salaResponseData['sala']['sala_id'];

        // Ahora intentar crear la invitación
        $response = $this->post('/api/invitaciones', [
            'sala_id' => $salaId,
            'email_invitado' => 'user@user.com',
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Ahora Logueamos con el usuario invitado para aceptar la invitación
        [$tokenInvitado, $userIdInvitado] = $this->authenticateAndGetUserToken();

        // Listamos las invitaciones recibidas para obtener el ID de la invitación y ver que el nombre de la sala es correcto
        $responseListInvitaciones = $this->get('/api/invitaciones/recibidas', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $tokenInvitado,
        ]);

        $invitacionesResponseData = json_decode($responseListInvitaciones->getContent(), true);
        $invitacionSalaName = $invitacionesResponseData['invitaciones'][0]['sala'];

        $this->assertEquals('zasfD453', $invitacionSalaName, "El nombre de la sala en la invitación no coincide con el esperado.");

        $invitacionId = $invitacionesResponseData['invitaciones'][0]['id'];

        // Ahora aceptamos la invitación
        $response = $this->post('/api/invitaciones/' . $invitacionId, [
            'respuesta' => true,
        ], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $tokenInvitado,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        // Verificar que el usuario ahora esta en la sala
        $userSalaRole = UserSalaRole::where('user_id', $userIdInvitado)
            ->where('sala_id', $salaId)
            ->first();

        $this->assertNotNull($userSalaRole, "El usuario no se encuentra en la sala.");

    }

}
