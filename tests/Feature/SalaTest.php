<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserSalaRole;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SalaSeeder;
use Database\Seeders\UserSalaRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SalaTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        // Cargamos los seeders con los datos de prueba
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(SalaSeeder::class);
        $this->seed(UserSalaRoleSeeder::class);
    }
    /**
     * Autentica un usuario user@user.com y devuelve el token
     */
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
     * Test para comprobar que un usuario puede listar sus salas
     */
    public function test_user_get_my_salas(): void
    {
        $user = User::where('email', 'user@user.com')->first();
        dump("User from seed:", $user?->id);
        $token = $this->authenticateAndGetToken();
        dump("Token:", $token);

        $recuentoSalasActuales = User::where('email', 'user@user.com')->first()->userSalaRoles()->count();
        $token = $this->authenticateAndGetToken();

        // Hacer una solicitud autenticada para obtener las salas del usuario
        $response = $this->get('/api/salas/me', [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(Response::HTTP_OK);

        // Verificar que las salas devueltas coincidan con las creadas
        $response->assertJsonCount($recuentoSalasActuales, 'salas');

    }

    /**
     * Test para comprobar que un usuario puede crear una sala
     */
    public function test_user_create_sala(): void
    {
        $recuentoSalasActuales = User::where('email', 'user@user.com')->first()->userSalaRoles()->count();
        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();
        $salaData = [
            'name' => 'Sala de Prueba',
        ];

        $response = $this->post('/api/salas', $salaData, [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(Response::HTTP_OK);

        // Verificar que la sala se haya creado correctamente
        $response->assertJsonFragment([
            'sala_name' => 'Sala de Prueba'
        ]);

        // Verificar que el recuento de salas del usuario haya aumentado en 1
        $nuevaCuentaSalas = User::where('email', 'user@user.com')->first()->userSalaRoles()->count();
        $this->assertEquals($recuentoSalasActuales + 1, $nuevaCuentaSalas);

    }

    /**
     * Test para comprobar un usuario puede eliminar una sala si es admin
     */

    public function test_user_delete_sala_if_admin(): void
    {

        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // Creamos una sala para asegurarnos que somos admin de ella
        $response = $this->post('/api/salas', [
            'name' => 'Sala de Prueba de Eliminacion',
        ], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response = json_decode($response->getContent(), true);

        $recuentoSalasActuales = User::where('email', 'user@user.com')->first()->userSalaRoles()->count();

        $response = $this->delete('/api/salas/' . $response['sala']['sala_id'], [], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(Response::HTTP_OK);

        // Verificar que el recuento de salas del usuario haya disminuido en 1
        $nuevaCuentaSalas = User::where('email', 'user@user.com')->first()->userSalaRoles()->count();
        $this->assertEquals($recuentoSalasActuales - 1, $nuevaCuentaSalas);

    }

    //  Test para comprobar un usuario puede actualizar el name de una sala si es admin

    public function test_user_update_sala_if_admin(): void
    {

        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // Creamos una sala (seremos admin al crearla)
        $response = $this->post('/api/salas', [
            'name' => 'Sala de Prueba de Actualizacion',
        ], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response = json_decode($response->getContent(), true);
        $salaId = $response['sala']['sala_id'];
        $newName = 'Sala Actualizada';
        $response = $this->patch('/api/salas/' . $salaId, [
            'name' => $newName,
        ], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(Response::HTTP_OK);

        // Verificar que el nombre de la sala se haya actualizado correctamente
        $response->assertJsonFragment([
            'name' => $newName
        ]);

        // Segunda verificacion: Comprobar en la base de datos que el nombre se ha actualizado
        $nameSalaEnBD = \App\Models\Sala::find($salaId)->name;
        $this->assertEquals($newName, $nameSalaEnBD, 'El nombre de la sala en la base de datos no coincide con el nombre actualizado.');

    }

    /**
     * Test para comprobar un usuario NO puede eliminar una sala si NO es admin
     */

    public function test_user_delete_sala_if_not_admin(): void
    {

        // Authentica el usuario y obtiene el token
        $token = $this->authenticateAndGetToken();

        // Creamos una sala (seremos admin al crearla)
        $response = $this->post('/api/salas', [
            'name' => 'Sala de Prueba de Eliminacion',
        ], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response = json_decode($response->getContent(), true);
        $salaId = $response['sala']['sala_id'];

        // Forzamos role de user para el usuario en la sala creada
        $userSalaRole = UserSalaRole::where('sala_id', $salaId);
        $userSalaRole->update([
            'role_id' => 2, // role user
        ]);

        $response = $this->delete('/api/salas/' . $salaId, [], [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        // Verificar que la respuesta sea exitosamente prohibida
        $response->assertStatus(Response::HTTP_FORBIDDEN);

    }



}
