<?php

namespace App\Docs\Swagger;

class CategoriesDoc
{


    /**
     * @OA\GET(
     *     path="/api/categoriess",
     *     operationId="categoriesIndex",
     *     summary="Devuelve todas las categorias. Requiere un token valido.",
     *     description="Devuelve todas las categorias",
     *     tags={"Categorías"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\Response(
     *         response=201,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(
     *                 property="categories",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/CategoryResource")
     *             )
     *         )
     *     )
     * )
     */

    public function index() {}

    /**
     * @OA\POST(
     *     path="/api/categories",
     *     operationId="categoriesStore",
     *     summary="Crea una categoria. Requiere un token de tipo ADMIN.",
     *     description="Crea una categoria",
     *     tags={"Categorías"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Comida")
     *         )
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Categoria creada correctamente"),
     *             @OA\Property(property="category", type="object", ref="#/components/schemas/CategoryResource")
     *         )
     *     )
     * )
     *    
     */
    public function store() {}

    /**
     * @OA\PATCH(
     *     path="/api/categories/{id}",
     *     summary="Actualiza una categoria. Requiere un token de tipo ADMIN.",
     *     description="Actualiza una categoria",
     *     tags={"Categorías"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Comida")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Categoria actualizada correctamente"),
     *             @OA\Property(property="category", type="object", ref="#/components/schemas/CategoryResource")
     *         )
     *     )
     * )
     * 
     */
    public function update() {}

    /**
     * @OA\DELETE(
     *     path="/api/categories/{id}",
     *     summary="Elimina una categoria. Requiere un token de tipo ADMIN.",
     *     description="Elimina una categoria",
     *     tags={"Categorías"},
     *     security={
     *         {"bearerAuth"={}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="1"),
     *             @OA\Property(property="message", type="string", example="Categoria eliminada correctamente"),
     *             @OA\Property(property="category", type="object", ref="#/components/schemas/CategoryResource")
     *         )
     *     )
     * )
     */
    public function delete() {}
}
