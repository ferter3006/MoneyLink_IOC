<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class CacheTokenService
{
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
        $buscoUsuario = array_search($user->id, $tokens);
        if ($buscoUsuario !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function borrarUsuarioDeCache(User $user)
    {
        $tokens = Cache::get('tokens', []);
        $tokenABorrar = array_search($user->id, $tokens);
        unset($tokens[$tokenABorrar]);        
        Cache::put('tokens', $tokens);
    }

    public function crearTokenParaUsuario(User $user)
    {
        $tokens = Cache::get('tokens', []);
        $token = (string) Uuid::uuid4();
        $tokens[$token] = $user->id;
        Cache::put('tokens', $tokens);
        return $token;
    }

    public function buscoTokenEnCacheDevuelvoUsuario(string $token): ?User
    {
        $tokens = Cache::get('tokens', []);        
        
        if (isset($tokens[$token])) {
            $userId = $tokens[$token];
            return User::find($userId);
        } else {
            return null;
        }
    }
}
