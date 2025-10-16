<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;

// Clase CacheTokenService, usada para gestionar los tokens de los usuarios
// Se usa Redis para almacenar los tokens y los usuarios
// Se duplican las entradas del token y el usuario en Redis, para mejorar la eficiencia de la búsqueda de tokens
// Al realizar una petición a la API con un token, se resetea el tiempo de expiración del token
/**
 * Class CacheTokenService. Clase que gestiona los tokens de los usuarios con Redis
 * @author Lluís Ferrater
 * @version 1.0
 */
class CacheTokenService
{
    // Tiempo de expiración del token en segundos
    public int $tiempoExpiracionToken = 1800; // 30 minutos

    /**
     * GenerateToken.Genera un token para el usuario y lo guarda en cache
     * @author Lluís Ferrater
     * @param User $user
     * @return Uuid $token
     */
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

    /**
     * buscoUsuarioEnCache. Busca si el usuario tiene un token en cache
     * @author Lluís Ferrater
     * @param User $user
     * @return bool
     */
    public function buscoUsuarioEnCache(User $user): bool
    {
        $token = Redis::get($user->id);
        if ($token) {
            return true;
        }
        return false;
    }

    /**
     * borrarUsuarioDeCache. Borra el token y el usuario de cache
     * @author Lluís Ferrater
     * @param User $user
     */
    public function borrarUsuarioDeCache(User $user)
    {
        $token = Redis::get($user->id);
        Redis::del($user->id);
        Redis::del($token);
    }

    /**
     * crearTokenParaUsuario. Crea un token para el usuario y lo guarda en cache.
     * El token se guarda con un tiempo de expiración.
     * Se guarda dos entradas, una para el token y otra para el usuario, para facil acceso
     * @author Lluís Ferrater
     * @param User $user
     * @return Uuid $token
     */
    public function crearTokenParaUsuario(User $user)
    {
        $token = (string) Uuid::uuid4();
        Redis::setex($token, $this->tiempoExpiracionToken, $user->id);
        Redis::setex($user->id, $this->tiempoExpiracionToken, $token);
        return $token;
    }
    
    /**
     * buscoTokenEnCacheDevuelvoIdUsuario. Busca un token en cache y devuelve el id de usuario si lo encuentra.
     * Si lo encuentra, actualiza el tiempo de expiración de las dos entradas.
     * Es la funcion que usa inicialmente los middlewares para verificar token
     * @author Lluís Ferrater
     * @param string $token
     * @return int $userId
     */
    public function buscoTokenEnCacheDevuelvoIdUsuario(string $token): ?string
    {
        $userId = Redis::get($token);
        if ($userId) {
            Redis::setex($token, $this->tiempoExpiracionToken, $userId);
            Redis::setex($userId, $this->tiempoExpiracionToken, $token);
        }
        return $userId;
    }
}
