<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\CacheTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{



    // Registro de usuarios
    public function store(StoreUserRequest $request)
    {
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
    public function login(LoginUserRequest $request, CacheTokenService $tokenService)
    {

        $requestEmail = $request->email;
        $requestPassword = $request->password;

        // Buscamos usuario en la base de datos
        $user = User::where('email', $requestEmail)->first();

        // Si no existe o la contraseña no coincide, devolvemos un error.
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
        $user = $request->get('userFromMiddleware');

        $tokenService->borrarUsuarioDeCache($user);

        return response()->json([
            'status' => '1',
            'message' => 'Logout correcto'
        ], Response::HTTP_OK);
    }

    // Update d'usuaris (me)
    // Solo permitimo modificar el usuario propio dueño del token.
    public function updateMe(UpdateUserRequest $request)
    {
        $user = $request->get('userFromMiddleware');

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;

        $user->save();

        return response()->json([
            'status' => '1',
            'user' => new UserResource($user)
        ]);
    }
   
    public function deleteMe(Request $request)
    {
        $user = $request->get('userFromMiddleware');

        $user->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Te has eliminado correctamente'
        ]);
    }

    // -------------------------------
    //         RUTAS ADMIN
    // -------------------------------

    // Listar usuarios
    public function index(Request $request)
    {
        $users = User::with('role:id,name')->get();

        return response()->json([
            'status' => '1',
            'users' => UserResource::collection($users)
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        return response()->json([
            'status' => '1',
            'user' => new UserResource($user)
        ]);
    }

    // Actualizar usuario
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $user->role_id = $request->role_id ?? $user->role_id;

        $user->save();

        return response()->json([
            'status' => '1',
            'user' => new UserResource($user)
        ]);
    }

    // Eliminar usuario
    public function delete($id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Usuario eliminado correctamente'
        ]);
    }
}
