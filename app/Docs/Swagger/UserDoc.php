<?php

namespace App\Docs\Swagger;

class UserDoc
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Lista todos los usuarios (Solo ADMIN)",
     *     description="Obtiene un listado completo de todos los usuarios registrados en el sistema. Esta operación requiere permisos de administrador.",
     *     tags={"Gestión de Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UserResource")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - No eres administrador",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     )
     * )
     */
    public function index() {}
    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Registro de nuevo usuario (Ruta pública)",
     *     description="Crea una cuenta de usuario nueva en el sistema. Esta ruta es pública y no requiere autenticación. La contraseña debe cumplir requisitos de seguridad: mínimo 8 caracteres, al menos una letra mayúscula y un carácter especial.",
     *     tags={"Gestión de Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del usuario a registrar",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "email", "password"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nombre del usuario",
     *                 example="Juan Pérez"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 description="Email único del usuario",
     *                 example="juan@example.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password",
     *                 description="Contraseña (mínimo 8 caracteres, 1 mayúscula, 1 carácter especial: !, @, #, $, %)",
     *                 example="Password@123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario registrado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación - Email ya existe o contraseña no cumple requisitos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="El email ya está registrado.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store() {}
    /**
     * @OA\Post(
     *     path="/api/users/login",
     *     summary="Inicio de sesión (Ruta pública)",
     *     description="Autentica un usuario con sus credenciales y devuelve un token Bearer para acceder a las rutas protegidas. El token debe incluirse en el header Authorization de las peticiones subsecuentes.",
     *     tags={"Gestión de Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Credenciales de acceso",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email", "password"},
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 description="Email del usuario",
     *                 example="juan@example.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password",
     *                 description="Contraseña del usuario",
     *                 example="Password@123"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login exitoso - Token de acceso generado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Login correcto"),
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 description="Token Bearer para autenticación en endpoints protegidos",
     *                 example="3|abcdef1234567890xyz..."
     *             ),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Credenciales incorrectas")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación - Email o password inválidos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="El email es requerido.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function login() {}

    /**
     * @OA\Post(
     *     path="/api/users/logout",
     *     summary="Cierre de sesión",
     *     description="Invalida el token Bearer actual del usuario autenticado. Después de hacer logout, el token ya no será válido y deberá iniciar sesión nuevamente para obtener uno nuevo.",
     *     tags={"Gestión de Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout exitoso - Token invalidado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Logout correcto")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function logout() {}

    /**
     * @OA\Patch(
     *     path="/api/users/me",
     *     summary="Actualiza tu perfil de usuario",
     *     description="Permite al usuario autenticado actualizar su propia información de perfil (nombre, email, contraseña). Todos los campos son opcionales - solo se actualizan los proporcionados. La contraseña debe cumplir los mismos requisitos de seguridad que en el registro.",
     *     tags={"Gestión de Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Campos a actualizar (todos opcionales)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nuevo nombre del usuario",
     *                 example="Juan Carlos"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 description="Nuevo email del usuario",
     *                 example="juancarlos@example.com"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password",
     *                 description="Nueva contraseña (mínimo 8 caracteres, 1 mayúscula, 1 carácter especial)",
     *                 example="NewPassword@456"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación - Email ya existe o contraseña no cumple requisitos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="El email ya está en uso.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function updateMe() {}

    /**
     * @OA\Delete(
     *     path="/api/users/me",
     *     summary="Elimina tu cuenta de usuario",
     *     description="Permite al usuario autenticado eliminar permanentemente su propia cuenta. Esta acción es irreversible y eliminará también sus datos asociados.",
     *     tags={"Gestión de Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Cuenta eliminada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Te has eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )     
     */
    public function deleteMe() {}

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Obtiene los detalles de un usuario (Solo ADMIN)",
     *     description="Muestra la información completa de un usuario específico. Esta operación requiere permisos de administrador.",
     *     tags={"Gestión de Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a consultar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario obtenido exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - No eres administrador",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
     * 
     */
    public function show() {}

    /**
     * @OA\Patch(
     *     path="/api/users/{id}",
     *     summary="Actualiza un usuario específico (Solo ADMIN)",
     *     description="Permite a un administrador actualizar la información de cualquier usuario, incluyendo su rol. Todos los campos son opcionales - solo se actualizan los proporcionados.",
     *     tags={"Gestión de Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=5
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Campos a actualizar (todos opcionales)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nuevo nombre del usuario",
     *                 example="María García"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 description="Nuevo email del usuario",
     *                 example="maria@example.com"
     *             ),  
     *             @OA\Property(
     *                 property="role_id",
     *                 type="integer",
     *                 description="ID del nuevo rol (1=admin, 2=user)",
     *                 example=2
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password",
     *                 description="Nueva contraseña (mínimo 8 caracteres, 1 mayúscula, 1 carácter especial)",
     *                 example="Password@789"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - No eres administrador",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación - Datos inválidos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="role_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="El rol seleccionado no existe.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Elimina un usuario (Solo ADMIN)",
     *     description="Permite a un administrador eliminar permanentemente cualquier cuenta de usuario. Esta acción es irreversible y eliminará también los datos asociados al usuario.",
     *     tags={"Gestión de Usuarios"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=5
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Usuario eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado - Token inválido o expirado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - No eres administrador",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
     * 
     */
    public function delete() {}
}
