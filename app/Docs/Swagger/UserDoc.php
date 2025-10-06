<?php

namespace App\Docs\Swagger;

class UserDoc
{
    /**
     * // -----------------------------------------------
     * //             LISTAR USUARIOS
     * // ----------------------------------------------
     *
     * @OA\Get(
     *     path="/api/users",
     *     summary="Devuelve todos los usuarios. Requiere un token de tipo Admin",
     *     description="Devuelve todos los usuarios registrados. Debe proporcionarse un token de tipo Admin",
     *     tags={"Gestión de Usuarios"},
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
    public function index() {}
    /**
     * // -----------------------------------------------
     * //             REGISTRO DE USUARIOS
     * // ----------------------------------------------
     *
     * @OA\Post(
     *     path="/api/users",
     *     summary="Registro de usuarios. Ruta publica.",
     *     description="Registro de usuarios.",
     *     tags={"Gestión de Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Pepe"),
     *             @OA\Property(property="email", type="string", example="pepe@pepe.com"),
     *             @OA\Property(
     *             property="password",
     *             type="string",
     *             example="Password@123",
     *             description="La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula y un carácter especial (por ejemplo: !, @, #, $, %)."
     * )
     
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(ref="#/components/schemas/UserResource")
     *         )
     *     )
     * )
     */
    public function store() {}
    /**
     * // -----------------------------------------------
     * //             LOGIN DE USUARIOS
     * // ----------------------------------------------
     *
     * @OA\Post(
     *     path="/api/users/login",
     *     summary="Login de usuarios. Ruta publica.",
     *     description="Login de usuarios",
     *     tags={"Gestión de Usuarios"},
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
    public function login() {}

    /**
     * // -----------------------------------------------
     * //             LOGOUT DE USUARIO
     * // ----------------------------------------------
     *
     * @OA\Post(
     *     path="/api/users/logout",
     *     summary="Logout de usuarios. Require un token valido.",
     *     description="Logout de usuarios",
     *     tags={"Gestión de Usuarios"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Logout correcto")
     *         )
     *     )
     * )
     */
    public function logout() {}

    /**
     * // -----------------------------------------------
     * //             UPDATE DE USUARIO
     * // ----------------------------------------------
     *
     * @OA\Patch(
     *     path="/api/users/me",
     *     summary="Update de usuario. Requiere un token valido.",
     *     description="Actualiza la información del usuario asociado al token Bearer proporcionado.",
     *     tags={"Gestión de Usuarios"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Pepe"),
     *             @OA\Property(property="email", type="string", example="pepe@pepe.com"),
     *             @OA\Property(
     *             property="password",
     *             type="string",
     *             example="Password@123",
     *             description="La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula y un carácter especial (por ejemplo: !, @, #, $, %)."
     * )
         
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(ref="#/components/schemas/UserResource")
     *         )
     *     )
     * )
     */
    public function update() {}
}
