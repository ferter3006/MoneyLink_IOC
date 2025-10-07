<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

class CacheTokenService
{
    final int $tiempoExpiracionToken = 1;

    public function generateToken(User $user)
    {
        $mensajeDebug = 'Flujo normal';


        if ($this->buscoUsuarioEnCache($user)) {
            $this->borrarUsuarioDeCache($user);
            $mensajeDebug = 'El usuario ya estaba logueado';
        }

        $tokenCreado = $this->crearTokenParaUsuario($user);
        //$tokenCreado = (string) Uuid::uuid4();


        return [
            'token' => $tokenCreado,
            'mensajeDebug' => $mensajeDebug
        ];
    }

    public function buscoUsuarioEnCache(User $user): bool
    {
        $tokens = Cache::get('tokens', []);
        foreach ($tokens as $token => $data) {
            if ($data['user_id'] == $user->id) {
                return true;
            }
        }
        return false;
    }

    public function borrarUsuarioDeCache(User $user)
    {
        $tokens = Cache::get('tokens', []);
        foreach ($tokens as $token => $data) {
            if ($data['user_id'] == $user->id) {
                unset($tokens[$token]);
            }
        }
        Cache::put('tokens', $tokens);
    }

    public function crearTokenParaUsuario(User $user)
    {
        $tokens = Cache::get('tokens', []);
        $token = (string) Uuid::uuid4();
        $tokens[$token] = [
            'user_id' => $user->id,
            'expires_at' => now()->addMinutes($this->tiempoExpiracionToken)
        ];
        Cache::put('tokens', $tokens);
        return $token;
    }

    public function buscoTokenEnCacheDevuelvoUsuario(string $token): ?User
    {
        $tokens = Cache::get('tokens', []);

        if (isset($tokens[$token])) {
            $userId = $tokens[$token]['user_id'];
            $tokens[$token]['expires_at'] = now()->addMinutes($this->tiempoExpiracionToken);
            return User::find($userId);
        } else {
            return null;
        }
    }

    public function borraTokensExpirados()
    {
        $tokens = Cache::get('tokens', []);
        foreach ($tokens as $token => $data) {
            if ($data['expires_at'] < now()) {
                unset($tokens[$token]);
            }
        }
        Cache::put('tokens', $tokens);
    }
}
