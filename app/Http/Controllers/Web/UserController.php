<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Services\CacheTokenService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends ControllerWeb
{
    public function index()
    {
        // Listar usuarios
        $users = User::all();

        return view('users.index', ['users' => $users]);
    }

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

       


        return view('dashboard', ['user' => $user]);
    }


}
