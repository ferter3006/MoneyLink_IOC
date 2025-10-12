<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\CacheTokenService;
use Closure;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Middleware de creación propia que verifica si el token es valido.
// Se hace merge con el request para pasar el usuario al siguiente paso y evitar que se vuelva a buscar en la base de datos.
class CheckIocToken
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
        $userId = $this->tokenService->buscoTokenEnCacheDevuelvoIdUsuario($token);
        $user = User::find($userId);

        if (!$user) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Token no valido',
                'token recibido' => $token,
            ], 404));
        }

        return $next($request->merge(['userFromMiddleware' => $user]));
    }
}
