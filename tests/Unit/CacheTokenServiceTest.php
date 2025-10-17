<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\CacheTokenService;
use Illuminate\Support\Facades\Redis;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class CacheTokenServiceTest
 * Comprobaciones de uso de redis para los tokens de usuarios
 * @author Lluís Ferrater
 * @version 1.0
 */

class CacheTokenServiceTest extends TestCase
{

    /**
     * Test de loguear un usuario.
     * Verificamos que se cree un token para el usuario
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_crear_token_para_usuario()
    {
        $service = new CacheTokenService();
        $user = (new User())->forceFill(['id' => 42]);

        // Redis::setex se deberia llamar dos veces:
        // - una con el id del usuario
        // - otra con el token

        Redis::shouldReceive('setex')
            ->once()
            ->ordered()
            ->with(Mockery::type('string'), $service->tiempoExpiracionToken, (string)$user->id);

        Redis::shouldReceive('setex')
            ->once()
            ->ordered()
            ->with((string)$user->id, $service->tiempoExpiracionToken, Mockery::type('string'));

        $token = $service->crearTokenParaUsuario($user);

        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }

    /**
     * Test de borrar un usuario de la cache.
     * Verificamos que se borre las dos entradas en Redis de la cache
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_borrar_usuario_de_cache()
    {
        // Creamos un usuario de prueba
        $user = (new User())->forceFill(['id' => 42]);

        // Redis deberia ser llamado una vez con el id del usuario
        Redis::shouldReceive('get')
            ->once()
            ->with($user->id)
            ->andReturn('zzztokenzzz');
        
        // Esperamos que Redis::del() sea llamado dos veces:
        // - una con el id del usuario
        // - una con el token
        Redis::shouldReceive('del')
            ->once()
            ->with($user->id);

        Redis::shouldReceive('del')
            ->once()
            ->with('zzztokenzzz');

        // Ejecutamos el método
        $service = new CacheTokenService();
        $service->borrarUsuarioDeCache($user);

        // Si coincide con lo esperado, el test pasa ✅
        $this->assertTrue(true);
    }

    /**
     * Test de busco y confirmo que un token que no esta en cache
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_busco_token_que_no_esta_en_cache()
    {
        // Redis deberia ser llamado una vez con el token
        Redis::shouldReceive('get')
            ->once();

        // Creo una instancia del servicio
        $service = new CacheTokenService();
        // Ejecuto el método
        $id = $service->buscoTokenEnCacheDevuelvoIdUsuario('zzztokenzzz');

        // Deberia devolver un id nulo (por ser inexistente)
        $this->assertNull($id);
    }

    /**
     * Test de busco un token que si esta en cache
     * Este es el test mas complejo que he echo.
     * He perdido media vida aquí xD
     * @author Lluís Ferrater
     * @version 1.0
     */
    public function test_busco_token_que_si_esta_en_cache()
    {
        // Creamos un servicio cacheTokenService y un usuario de prueba
        $service = new CacheTokenService();
        $user = (new User())->forceFill(['id' => 42]);


        // Crearemos un token primero, asi que Redis::setex se deberia llamar dos veces
        Redis::shouldReceive('setex')
            ->once()
            ->ordered()
            ->with(Mockery::type('string'), $service->tiempoExpiracionToken, (string)$user->id);

        Redis::shouldReceive('setex')
            ->once()
            ->ordered()
            ->with((string)$user->id, $service->tiempoExpiracionToken, Mockery::type('string'));

        // Creamos el token (lo que consume las 2 llamadas a Redis::setex anteriores)
        $token = $service->crearTokenParaUsuario($user);

        // Comprobamos que vamos bien con estas dos llamadas
        $this->assertNotEmpty($token);
        $this->assertIsString($token);

        // Ahora se deberia llamar Redis::get con el token y devolver el id del usuario
        Redis::shouldReceive('get')
            ->once()
            ->with($token)
            ->andReturn($user->id);

        // Y como el usuario sí que esta en la cache
        // Deberia actualizar los tiempos de expiración
        // Y realizar 2 llamadas a Redis::setex con el id del usuario y el token
        Redis::shouldReceive('setex')
            ->once()
            ->ordered()
            ->with(Mockery::type('string'), $service->tiempoExpiracionToken, (string)$user->id);

        Redis::shouldReceive('setex')
            ->once()
            ->ordered()
            ->with((string)$user->id, $service->tiempoExpiracionToken, Mockery::type('string'));

        // Ejecutamos el metodo
        $userId = $service->buscoTokenEnCacheDevuelvoIdUsuario($token);

        // Comprobamos que nos devuelve el id correcto
        $this->assertEquals($user->id, $userId);
    }
}
