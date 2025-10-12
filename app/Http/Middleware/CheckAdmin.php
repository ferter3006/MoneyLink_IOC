<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\CacheTokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Middleware de creación propia que verifica si el usuario es admin.
// Verifica si el token es valido y si el usuario dueño del token es admin.
// Se hace merge con el request para pasar el usuario al siguiente paso y evitar que se vuelva a buscar en la base de datos.
class CheckAdmin
{
    protected $tokenService;

    public function __construct()
    {
        $this->tokenService = new CacheTokenService();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $idUser = $this->tokenService->buscoTokenEnCacheDevuelvoIdUsuario($token);
        $user = User::with('role')->find($idUser);

        if (!$user || $user->role->name != 'admin') {
            return response()->json([
                'status' => '0',
                'message' => 'Token invalido para admin',
                'token recibido' => $token,
                'uaser' => $user
            ]);
        }

        return $next($request->merge(['userFromMiddleware' => $user]));
    }
}
