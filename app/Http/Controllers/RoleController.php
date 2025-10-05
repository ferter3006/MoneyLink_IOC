<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Devuelve todos los roles",
     *     description="Devuelve todos los roles y usuarios registrados",
     *     tags={"Roles"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Admin")
     *                 )
     *             ),
     *         )
     *     )
     * )
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
