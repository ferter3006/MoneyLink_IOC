<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\CacheTokenService;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckIocToken. Clase que verifica si el token es valido. 
 * @author Lluís Ferrater
 * @version 1.0
 */
class CheckIocToken
{

    protected $tokenService;

    public function __construct()
    {
        $this->tokenService = new CacheTokenService();
    }

    /**
     * Handle. Verifica si el token es valido.
     * Si no lo es, devuelve una respuesta de error
     * Si lo es, mergea el usuario en la request y lo devuelve
     * 
     * @author Lluís Ferrater
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return \Illuminate\Http\Response     
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Token inexistente, envialo en el header Authorization',
                'token recibido' => $token,
            ], HttpResponse::HTTP_UNAUTHORIZED));
        }
        $userId = $this->tokenService->buscoTokenEnCacheDevuelvoIdUsuario($token);
        $user = User::find($userId);

        if (!$user) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Token no valido',
                'token recibido' => $token,
            ], HttpResponse::HTTP_UNAUTHORIZED));
        }

        return $next($request->merge(['userFromMiddleware' => $user]));
    }
}
