<?php

namespace App\Http\Middleware;

use App\Services\CacheTokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $user = $this->tokenService->buscoTokenEnCacheDevuelvoUsuario($token);

        if (!$user || $user->role_name != 'admin') {
            return response()->json([
                'status' => '0',
                'message' => 'Token invalido para admin',
                'token recibido' => $token,
            ]);
        }



        return $next($request);
    }
}
