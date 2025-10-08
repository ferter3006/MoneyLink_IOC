<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;

class CacheTokenService
{
    final int $tiempoExpiracionToken = 15; // 15 segundos

    public function generateToken(User $user)
    {

        if ($this->buscoUsuarioEnCache($user)) {
            $this->borrarUsuarioDeCache($user);
        }

        $tokenCreado = $this->crearTokenParaUsuario($user);

        return [
            'token' => $tokenCreado,
        ];
    }

    public function buscoUsuarioEnCache(User $user): bool
    {
        $token = Redis::get($user->id);
        if ($token) {
            return true;
        }
        return false;
    }

    public function borrarUsuarioDeCache(User $user)
    {
        $token = Redis::get($user->id);
        Redis::del($user->id);
        Redis::del($token);
    }

    public function crearTokenParaUsuario(User $user)
    {
        $token = (string) Uuid::uuid4();
        Redis::setex($token, $this->tiempoExpiracionToken, $user->id);
        Redis::setex($user->id, $this->tiempoExpiracionToken, $token);
        return $token;
    }

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
