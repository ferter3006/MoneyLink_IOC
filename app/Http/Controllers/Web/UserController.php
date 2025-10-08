<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ControllerWeb
{
    public function index()
    {
        // Listar usuarios
        $users = User::all();

        return view('users.index', ['users' => $users]);
    }
}
