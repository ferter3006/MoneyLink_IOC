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

    
    /**
     * Test de petición GET a una ruta privada sin token. 
     * Comprueba que la petición sin token devuelve un 401 UNAUTHORIZED
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_get_salas_sin_token(): void
    {
        $response = $this->get('api/salas/me');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
    
    /**
     * Test de petición GET a una ruta privada con token. 
     * Comprueba que la petición con token devuelve un 200 OK
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_get_salas_con_token(): void
    {
        // Cojo un usuario de la base de datos y genero un token para el
        $user = User::all()->first();
        $cacherSevice = new CacheTokenService();
        $token = $cacherSevice->crearTokenParaUsuario($user);

        // Realizo la petición GET con el token
        $response = $this->get('api/salas/me', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
    
    /**
     * Test de petición GET a una ruta restringida ADMIN con un token de USER
     * Comprueba que la petición con token devuelve un 403 FORBIDDEN
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_get_roles_con_token_user(): void
    {
        // Cojo un usuario con rol USER de la base de datos y genero un token para el
        $role_id = Role::where('name', 'user')->first()->id;
        $user = User::where('role_id', $role_id)->first();

        $cacherSevice = new CacheTokenService();
        $token = $cacherSevice->crearTokenParaUsuario($user);

        // Realizo la petición GET con el token de USER en una ruta restringida a ADMIN
        $response = $this->get('api/roles', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    
    /**
     * Test de petición GET a una ruta restringida ADMIN con un token de ADMIN
     * Comprueba que la petición con token devuelve un 200 OK
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_get_roles_con_token_admin(): void
    {
        // Cojo un usuario con rol ADMIN de la base de datos y genero un token para el
        $role_id = Role::where('name', 'admin')->first()->id;
        $user = User::where('role_id', $role_id)->first();

        $cacherSevice = new CacheTokenService();
        $token = $cacherSevice->crearTokenParaUsuario($user);

        // Realizo la petición GET con el token de ADMIN en una ruta restringida a ADMIN
        $response = $this->get('api/roles', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test de petición GET a una ruta inexistente. 
     * Comprueba que la petición devuelve un 404 NOT FOUND
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_get_a_una_ruta_inexistente(): void
    {
        error_log('inicio');
        $response = $this->get('api/hola/quetal');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        error_log('fin');
    }
}
