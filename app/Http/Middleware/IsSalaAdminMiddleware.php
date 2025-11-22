<?php

namespace App\Http\Middleware;

use App\Models\UserSalaRole;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSalaAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userFromMiddleware = $request->get('userFromMiddleware');
        $salaId = $request->route('salaId');

        $userInSalaWithRole = UserSalaRole::where('user_id', $userFromMiddleware->id)
            ->where('sala_id', $salaId)
            ->first();

        if (!$userInSalaWithRole) {
            return new JsonResponse([
                'status' => '0',
                'message' => 'No estás en esta sala o no existe!',
            ], 403);
        }

        if ($userInSalaWithRole->role->name !== 'admin') {
            return new JsonResponse([
                'status' => '0',
                'message' => 'No eres admin para realizar esta acción!'
            ], 403);
        }


        return $next($request);
    }
}
