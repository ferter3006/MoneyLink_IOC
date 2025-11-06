<?php

namespace App\Docs\Swagger;

class SalasDoc
{

    /**
     * @OA\Get(
     *     path="/api/salas/me",
     *     summary="Lista las salas del usuario autenticado",
     *     description="Obtiene todas las salas en las que participa el usuario autenticado, incluyendo su rol en cada sala y los otros usuarios de cada sala",
     *     tags={"Salas"},
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
     *                 property="salas",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/UserSalaRolesGetSalasMeResource")
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
     *     )
     * )
     */

    public function index() {}

    /**
     * @OA\Post(
     *     path="/api/salas",
     *     summary="Crea una nueva sala",
     *     description="Crea una sala y asigna automáticamente al usuario creador como ADMIN de la sala",
     *     tags={"Salas"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de la nueva sala",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nombre de la sala (mínimo 3 caracteres, máximo 255)",
     *                 example="Gastos del piso compartido"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sala creada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Sala creada correctamente"),
     *             @OA\Property(property="sala", ref="#/components/schemas/UserSalaRoleResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The name field is required."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="array",
     *                     @OA\Items(type="string", example="The name field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     * 
     */
    public function store() {}

    /**
     * @OA\Post(
     *     path="/api/salas/with_invitations",
     *     summary="Crea una sala y envía invitaciones",
     *     description="Crea una nueva sala, asigna al usuario creador como ADMIN y envía invitaciones a los emails proporcionados en el mismo request. Los usuarios invitados deben estar registrados en el sistema.",
     *     tags={"Salas"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de la nueva sala e invitaciones",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "invitaciones"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nombre de la sala (mínimo 3 caracteres, máximo 255)",
     *                 example="Gastos del piso compartido"
     *             ),
     *             @OA\Property(
     *                 property="invitaciones",
     *                 type="array",
     *                 description="Array de emails a invitar (no se permiten duplicados ni invitarse a sí mismo)",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"email"},
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         format="email",
     *                         description="Email del usuario registrado a invitar",
     *                         example="amigo@example.com"
     *                     )
     *                 ),
     *                 example={
     *                     {"email": "usuario1@example.com"},
     *                     {"email": "usuario2@example.com"}
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sala creada e invitaciones enviadas exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Sala creada correctamente y 2 invitación(es) enviada(s)"),
     *             @OA\Property(property="sala", ref="#/components/schemas/UserSalaRoleResource"),
     *             @OA\Property(property="invitaciones_enviadas", type="integer", description="Número de invitaciones enviadas", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación - Email no existe, duplicado, o intento de autoinvitación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="invitaciones.0.email",
     *                     type="array",
     *                     @OA\Items(type="string", example="No puedes invitarte a ti mismo.")
     *                 ),
     *                 @OA\Property(
     *                     property="invitaciones.1.email",
     *                     type="array",
     *                     @OA\Items(type="string", example="No se permiten emails duplicados en las invitaciones")
     *                 )
     *             )
     *         )
     *     )
     * )
     * 
     */
    public function storeWithInvitations() {}

    /**
     * @OA\Get(
     *     path="/api/salas/{id}/{m}",
     *     summary="Obtiene el detalle de una sala en un mes específico",
     *     description="Muestra el estado financiero de una sala (ingresos, gastos, balance) y todos sus tiquets en un mes específico. El parámetro 'm' permite navegar entre meses: 0 = mes actual, -1 = mes anterior, -2 = hace 2 meses, 1 = mes siguiente, etc.",
     *     tags={"Salas"},
     *     security={{"bearerAuth"={}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la sala a consultar",
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Parameter(
     *         name="m",
     *         in="path",
     *         required=true,
     *         description="Desplazamiento del mes respecto al actual (0 = actual, -1 = anterior, 1 = siguiente)",
     *         @OA\Schema(type="integer"),
     *         example=0
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Detalle de la sala obtenido exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="mes", type="integer", description="Mes consultado (1-12)", example=11),
     *             @OA\Property(property="año", type="integer", description="Año consultado", example=2025),
     *             @OA\Property(property="sala", ref="#/components/schemas/SalaResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - El usuario no pertenece a esta sala",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="No tienes permiso para ver esta sala")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sala no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Sala no encontrada")
     *         )
     *     )
     * )
     */


    public function show() {}

    /**
     * @OA\Patch(
     *     path="/api/salas/{id}",
     *     summary="Actualiza el nombre de una sala",
     *     description="Permite actualizar el nombre de una sala. Solo los usuarios con rol ADMIN pueden realizar esta acción",
     *     tags={"Salas"},
     *     security={{"bearerAuth"={}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la sala a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nuevos datos de la sala",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nuevo nombre de la sala (mínimo 3 caracteres, máximo 255)",
     *                 example="Gastos del apartamento 2025"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Sala actualizada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Sala actualizada correctamente"),
     *             @OA\Property(property="sala", ref="#/components/schemas/SalaResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - Solo los ADMIN pueden modificar la sala",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="No tienes permiso para modificar esta sala")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sala no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Sala no encontrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The name field is required."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="array",
     *                     @OA\Items(type="string", example="The name must be at least 3 characters.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */


    public function update() {}


    /**
     * @OA\Patch(
     *     path="/api/salas/{id}/users/{userId}",
     *     summary="Actualiza el rol de un usuario en una sala",
     *     description="Permite a un ADMIN cambiar el rol de otro usuario en la sala. No se puede modificar el propio rol. Roles disponibles: 1=ADMIN, 2=USER",
     *     tags={"Salas"},
     *     security={{"bearerAuth"={}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la sala",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID del usuario cuyo rol se quiere modificar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=3
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Nuevo rol para el usuario",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"role_id"},
     *                 @OA\Property(
     *                     property="role_id",
     *                     type="integer",
     *                     description="ID del nuevo rol (1=ADMIN, 2=USER)",
     *                     example=2
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol actualizado exitosamente - Devuelve la sala del usuario autenticado con los otros usuarios actualizados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Rol actualizado correctamente"),
     *             @OA\Property(property="sala", ref="#/components/schemas/UserSalaRolesGetSalasMeResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - Solo ADMIN puede modificar roles o intento de modificar el propio rol",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="No puedes modificar tu propio rol")
     *         )
     *     ),
     *     @OA\Response(                                                                
     *         response=404,
     *         description="Sala o usuario no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado en esta sala")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación - role_id inválido o no existe",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The selected role id is invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="role_id",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The selected role id is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     ) 
     * )
     */
    public function updateRole() {}

    /**
     * @OA\Delete(
     *     path="/api/salas/{id}",
     *     summary="Elimina una sala",
     *     description="Elimina permanentemente una sala y todas sus relaciones (usuarios, tiquets). Solo los usuarios con rol ADMIN pueden realizar esta acción. Esta operación no se puede deshacer.",
     *     tags={"Salas"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la sala a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sala eliminada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Sala eliminada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Sin permisos - Solo los ADMIN pueden eliminar la sala",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="No tienes permiso para modificar esta sala")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sala no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Sala no encontrada")
     *         )
     *     )
     * )
     * */
    public function delete() {}
}
