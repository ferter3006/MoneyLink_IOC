<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

/**
 * Controlador de roles
 * @author Lluís Ferrater
 * @version 1.0
 * NOTA: No hay validaciones de tokens por que no es necesario,
 * ya que los tokens se validan en el middleware antes de llegar al controlador
 */
class RoleController extends Controller
{

    /**
     * index (Muestra todos los roles)
     * @author Lluís Ferrater
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la lista de roles
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id')->get();

        return response()->json([
            'status' => '1',
            'roles' => RoleResource::collection($roles),
        ]);
    }
}
