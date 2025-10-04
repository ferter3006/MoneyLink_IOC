<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\CacheTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role:id,name')->get();

        return response()->json([
            'status' => '1',
            'users' => UserResource::collection($users)
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    // Login d'usuaris
    public function login(Request $request, CacheTokenService $tokenService)
    {
        // Validem que existi el email i la contrasenya
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $requestEmail = $request->email;
        $requestPassword = $request->password;

        // Busquem l'usuari a la base de dades
        $user = User::where('email', $requestEmail)->first();

        // Si no existeix l'usuari o la contrasenya no coincideixen retornem un error
        if (!$user || !Hash::check($requestPassword, $user->password)) {
            return response()->json([
                'status' => '0',
                'message' => 'El usuario no existe'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $resultado = $tokenService->generateToken($user);

        return response()->json([
            'status' => '1',
            'message' => 'Login correcto',
            'token' => $resultado['token'],
            'mensajeDebug' => $resultado['mensajeDebug']
        ], Response::HTTP_OK);
    }

    public function logout(Request $request, CacheTokenService $tokenService)
    {
        $token = $request->bearerToken();
        $user = $tokenService->buscoTokenEnCacheDevuelvoUsuario($token);

        if (!$user) {
            return response()->json([
                'status' => '0',
                'message' => 'Logout incorrecto'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $tokenService->borrarUsuarioDeCache($user);

        return response()->json([
            'status' => '1',
            'message' => 'Logout correcto'
        ], Response::HTTP_OK);
    }
}
