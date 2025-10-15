<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\CacheTokenService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de creación propia que verifica si el usuario es admin.
 * @author Lluís Ferrater
 * @version 1.0 * 
 */
class CheckAdmin
{
    protected $tokenService;

    public function __construct()
    {
        $this->tokenService = new CacheTokenService();
    }
    /**
     * Handle. Verifica si el usuario es admin (via token).
     * Si no lo es, devuelve una respuesta de error
     * Si lo es, mergea el usuario en la request y lo devuelve
     * 
     * @author Lluís Ferrater
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $idUser = $this->tokenService->buscoTokenEnCacheDevuelvoIdUsuario($token);
        $user = User::with('role')->find($idUser);

        if (!$user) {
            return response()->json([
                'status' => '0',
                'message' => 'Token no valido!'
            ], HttpResponse::HTTP_UNAUTHORIZED);
        }

        if ($user->role->name != 'admin') {
            return response()->json([
                'status' => '0',
                'message' => 'Tu no eres admin!'
            ], HttpResponse::HTTP_FORBIDDEN);
        }

        return $next($request->merge(['userFromMiddleware' => $user]));
    }
}
