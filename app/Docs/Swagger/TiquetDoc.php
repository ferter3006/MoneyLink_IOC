<?php

namespace App\Docs\Swagger;

class TiquetDoc
{

    /**
     * @OA\Post(
     *     path="/api/tiquets",
     *     summary="Crea un nuevo tiquet",
     *     description="Registra un nuevo tiquet (ingreso o gasto) en una sala específica. Debes ser miembro de la sala para crear tiquets en ella.",
     *     tags={"Tiquets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del tiquet a crear",
     *         @OA\JsonContent(
     *             type="object",
     *             required={"sala_id", "category_id", "es_ingreso", "description", "amount"},
     *             @OA\Property(
     *                 property="sala_id",
     *                 type="integer",
     *                 description="ID de la sala donde se registra el tiquet",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="category_id",
     *                 type="integer",
     *                 description="ID de la categoría del tiquet (debe pertenecer a la sala)",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="es_ingreso",
     *                 type="boolean",
     *                 description="true = ingreso, false = gasto",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Descripción del tiquet",
     *                 example="Salario del mes"
     *             ),
     *             @OA\Property(
     *                 property="amount",
     *                 type="number",
     *                 format="float",
     *                 description="Cantidad del tiquet (debe ser positiva)",
     *                 example=1500.50
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tiquet creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Tiquet creado correctamente"),
     *             @OA\Property(property="tiquet", ref="#/components/schemas/TiquetResource")
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
     *         description="Sin permisos - No eres miembro de la sala",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
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
     *                     property="sala_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="La sala seleccionada no existe.")
     *                 )
     *             )
     *         )
     *     )
     * )
     * 
     */

    public function store() {}

    /**
     * @OA\Patch(
     *     path="/api/tiquets/{id}",
     *     summary="Actualiza un tiquet existente",
     *     description="Modifica los datos de un tiquet. Solo puedes actualizar tiquets de salas donde eres miembro. Todos los campos son opcionales.",
     *     tags={"Tiquets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del tiquet a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Campos a actualizar (todos opcionales)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="category_id",
     *                 type="integer",
     *                 description="Nueva categoría del tiquet",
     *                 example=2
     *             ),
     *             @OA\Property(
     *                 property="es_ingreso",
     *                 type="boolean",
     *                 description="Cambiar tipo: true = ingreso, false = gasto",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Nueva descripción",
     *                 example="Compra en supermercado"
     *             ),
     *             @OA\Property(
     *                 property="amount",
     *                 type="number",
     *                 format="float",
     *                 description="Nueva cantidad",
     *                 example=45.99
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tiquet actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Tiquet actualizado correctamente"),
     *             @OA\Property(property="tiquet", ref="#/components/schemas/TiquetResource")
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
     *         description="Sin permisos - No eres miembro de la sala del tiquet",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tiquet no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Tiquet no encontrado")
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
     *                     property="category_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="La categoría seleccionada no existe.")
     *                 )
     *             )
     *         )
     *     )
     * )
     * 
     */

    public function update() {}


    /**
     * @OA\Delete(
     *     path="/api/tiquets/{id}",
     *     summary="Elimina un tiquet",
     *     description="Elimina permanentemente un tiquet de una sala. Solo puedes eliminar tiquets de salas donde eres miembro.",
     *     tags={"Tiquets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del tiquet a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tiquet eliminado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Tiquet eliminado correctamente")
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
     *         description="Sin permisos - No eres miembro de la sala del tiquet",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tiquet no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Tiquet no encontrado")
     *         )
     *     )
     * )
     * 
     */

    public function delete() {}

    /**
     * @OA\Get(
     *     path="/api/tiquets/{id}",
     *     summary="Obtiene los detalles de un tiquet",
     *     description="Muestra la información completa de un tiquet específico. Solo puedes ver tiquets de salas donde eres miembro.",
     *     tags={"Tiquets"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del tiquet a consultar",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tiquet obtenido exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="tiquet", ref="#/components/schemas/TiquetResource")
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
     *         description="Sin permisos - No eres miembro de la sala del tiquet",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tiquet no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="0"),
     *             @OA\Property(property="message", type="string", example="Tiquet no encontrado")
     *         )
     *     )
     * )
     * 
     */

    public function show() {}
}
