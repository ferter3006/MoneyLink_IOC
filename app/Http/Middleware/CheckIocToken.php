<?php

namespace App\Http\Middleware;

use App\Services\CacheTokenService;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

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
        $user = $this->tokenService->buscoTokenEnCacheDevuelvoUsuario($token);
        //$user = false;

        if (!$user) {

            return response()->json([
                'status' => '0',
                'message' => 'Token invalido',
                'token recibido' => $token,
                'cache test' => Cache::get($token),
            ]);
        }

        return $next($request);
    }
}
