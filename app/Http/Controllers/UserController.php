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
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Devuelve todos los usuarios. Requiere un token Bearer válido",
     *     description="Devuelve todos los usuarios registrados",
     *     tags={"Usuarios"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     )
     * )
     */

    public function index(Request $request)
    {
        $users = User::with('role:id,name')->get();

        return response()->json([
            'status' => '1',
            'users' => UserResource::collection($users)
        ]);
    }

    // Registro d'usuaris
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => '1',
            'user' => UserResource::single($user)
        ]);
    }

    // Login d'usuaris
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login de usuarios",
     *     description="Login de usuarios",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string", example="pepe@pepe.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Login correcto"),
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *             @OA\Property(property="mensajeDebug", type="string", example="debug info")
     *         )
     *     )
     * )
     */

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
