<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\InfoMailNewUser;
use App\Models\User;
use App\Models\UserSalaRole;
use App\Services\CacheTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

use function Laravel\Prompts\error;

/**
 * Controlador de usuarios
 * @author Lluís Ferrater
 * @version 1.0
 * NOTA: No hay validaciones de tokens por que no es necesario,
 * ya que los tokens se validan en el middleware antes de llegar al controlador
 */
class UserController extends Controller
{

    /**
     * Guarda un nuevo usuario en la base de datos.
     *
     * @author Lluís Ferrater
     * @param StoreUserRequest $request Request con los datos validados del usuario
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el usuario creado
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        // Enviar email al administrador informando de un nuevo usuario registrado
        $miEmail = 'ferratersimon@gmail.com';
        Mail::to($miEmail)->send(new InfoMailNewUser($user));


        return response()->json([
            'status' => '1',
            'user' => new UserResource($user)
        ]);
    }

    /**
     * Loguea un usuario en la base de datos.
     * @author Lluís Ferrater
     * @param LoginUserRequest $request Request con los datos validados del usuario
     * @param CacheTokenService $tokenService Servicio de cache de tokens para verificar el token
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el usuario logueado
     */

    public function login(LoginUserRequest $request, CacheTokenService $tokenService)
    {

        $requestEmail = $request->email;
        $requestPassword = $request->password;

        // Buscamos usuario en la base de datos
        $user = User::where('email', $requestEmail)          
            ->first();

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

    /**
     * logout (Desloguea un usuario)
     * @author Lluís Ferrater
     * @param Request $request
     * @param CacheTokenService $tokenService Servicio de cache de tokens para verificar el token
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y un mensaje
     */
    public function logout(Request $request, CacheTokenService $tokenService)
    {
        $user = $request->get('userFromMiddleware');

        $tokenService->borrarUsuarioDeCache($user);

        return response()->json([
            'status' => '1',
            'message' => 'Logout correcto'
        ], Response::HTTP_OK);
    }

    /**
     * update (Actualiza un usuario)
     * @author Lluís Ferrater
     * @param UpdateUserRequest $request Request con los datos validados del usuario
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el usuario actualizado
     */
    public function updateMe(UpdateUserRequest $request)
    {
        $user = $request->attributes->get('userFromMiddleware');

        error_log($user->name);;
        $user->name = $request->name ?? $user->name;
        error_log($request->name);
        $user->email = $request->email ?? $user->email;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;

        $user->save();

        return response()->json([
            'status' => '1',
            'user' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * delete (Elimina un usuario)
     * @author Lluís Ferrater
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y un mensaje
     */


    public function deleteMe(Request $request)
    {
        $user = $request->get('userFromMiddleware');

        $user->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Te has eliminado correctamente'
        ], Response::HTTP_OK);
    }

    // -------------------------------
    //         RUTAS ADMIN
    // -------------------------------

    /**
     * index (Muestra todos los usuarios)
     * @author Lluís Ferrater
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la lista de usuarios
     */
    public function index(Request $request)
    {
        $users = User::with('role:id,name')->get();

        return response()->json([
            'status' => '1',
            'users' => UserResource::collection($users)
        ], Response::HTTP_OK);
    }

    /**
     * show (Muestra un usuario)
     * @author Lluís Ferrater
     * @param int $id (Id del usuario a mostrar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el usuario
     */


    public function show($id)
    {
        $user = User::find($id);

        return response()->json([
            'status' => '1',
            'user' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    /**
     * update (Actualiza un usuario)
     * @author Lluís Ferrater
     * @param UpdateUserRequest $request Request con los datos validados del usuario
     * @param int $id (Id del usuario a actualizar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y el usuario actualizado
     */

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
        ], Response::HTTP_OK);
    }

    /**
     * delete (Elimina un usuario)
     * @author Lluís Ferrater
     * @param int $id (Id del usuario a eliminar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y un mensaje
     */

    public function delete($id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Usuario eliminado correctamente'
        ], Response::HTTP_OK);
    }
}
