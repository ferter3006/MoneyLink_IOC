<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\CacheTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    // Listar usuarios
    public function index(Request $request)
    {
        $users = User::with('role:id,name')->get();

        return response()->json([
            'status' => '1',
            'users' => UserResource::collection($users)
        ]);
    }

    // Registro de usuarios
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // Al menos una letra mayúscula
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Al menos un carácter especial
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        return response()->json([
            'status' => '1',
            'user' => new UserResource($user)
        ]);
    }

    // Login de usuarios.
    // - Se crea el token y se guarda en el cache.

    public function login(Request $request, CacheTokenService $tokenService)
    {
        error_log('Login POST');
        // Validem que existi el email i la contrasenya
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ], [
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser una cadena de caracteres',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
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
            'user' => new UserResource($user),

        ], Response::HTTP_OK);
    }

    // Logout d'usuaris
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

    // Update d'usuaris (me)
    // Solo permitimo modificar el usuario propio dueño del token.
    public function updateMe(Request $request)
    {
        $user = $request->get('userFromMiddleware');

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,{$user->id}',
            'password' => [
                'sometimes',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // Al menos una letra mayúscula
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Al menos un carácter especial  
            ]
        ]);

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;

        $user->save();

        return response()->json([
            'status' => '1',
            'user' => new UserResource($user)
        ]);
    }
}
