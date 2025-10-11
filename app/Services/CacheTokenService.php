<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;

// Clase CacheTokenService, usada para gestionar los tokens de los usuarios
// Se usa Redis para almacenar los tokens y los usuarios
// Se duplican las entradas del token y el usuario en Redis, para mejorar la eficiencia de la búsqueda de tokens
// Al realizar una petición a la API con un token, se resetea el tiempo de expiración del token

class CacheTokenService
{
    // Tiempo de expiración del token en segundos
    private int $tiempoExpiracionToken = 1200; // 20 minutos

    // Genera un token para el usuario
    public function generateToken(User $user)
    {
        // Si el usuario ya tiene un token en cache, lo borro
        if ($this->buscoUsuarioEnCache($user)) {
            $this->borrarUsuarioDeCache($user);
        }

        // Creo un token para el usuario
        $tokenCreado = $this->crearTokenParaUsuario($user);

        // Devuelvo el token creado
        return [
            'token' => $tokenCreado,
        ];
    }

    // Verifica si el usuario tiene un token en cache
    public function buscoUsuarioEnCache(User $user): bool
    {
        $token = Redis::get($user->id);
        if ($token) {
            return true;
        }
        return false;
    }

    // Borra la dos entradas del usuario en cache
    public function borrarUsuarioDeCache(User $user)
    {
        $token = Redis::get($user->id);
        Redis::del($user->id);
        Redis::del($token);
    }

    // Crea un token para el usuario
    public function crearTokenParaUsuario(User $user)
    {
        $token = (string) Uuid::uuid4();
        Redis::setex($token, $this->tiempoExpiracionToken, $user->id);
        Redis::setex($user->id, $this->tiempoExpiracionToken, $token);
        return $token;
    }

    // Busco token en cache y devuelvo el usuario si lo encuentro
    // Si lo encuentro, actualizo el tiempo de expiración de las dos entradas
    // Es la funcion que usa inicialmente los middlewares para verificar token
    public function buscoTokenEnCacheDevuelvoUsuario(string $token): ?User
    {
        $userId = Redis::get($token);
        if ($userId) {
            Redis::setex($token, $this->tiempoExpiracionToken, $userId);
            Redis::setex($userId, $this->tiempoExpiracionToken, $token);
            return User::find($userId);
        } else {
            return null;
        }
    }
}
