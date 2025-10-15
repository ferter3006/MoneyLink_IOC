<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\CacheTokenService;
use Illuminate\Support\Facades\Redis;
use Mockery;
use PHPUnit\Framework\TestCase;

class CacheTokenServiceTest extends TestCase
{

    public function test_loguear_usuario()
    {
        $service = new CacheTokenService();
        $user = new User(['id' => 42]);

        // Redis::setex se deberia llamar dos veces:
        // - una con el id del usuario
        // - otra con el token

        Redis::shouldReceive('setex')
            ->once()
            ->ordered()
            ->with(Mockery::type('string'), 1800, (string)$user->id);

        Redis::shouldReceive('setex')
            ->once()
            ->ordered()
            ->with((string)$user->id, 1800, Mockery::type('string'));

        $token = $service->crearTokenParaUsuario($user);

        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }
    
    public function test_borrar_usuario_de_cache()
    {
        // Creamos un usuario de prueba
        $user = new User(
            [
                'id' => 99,
                'name' => 'Fran!'
            ]
        );

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
}
