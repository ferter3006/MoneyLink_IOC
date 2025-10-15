<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categorias\StoreCategoriaRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Controlador de categorias
 * @author Lluís Ferrater
 * @version 1.0
 * Nota: No hay validaciones de tokens por que no es necesario,
 * ya que los tokens se validan en el middleware antes de llegar al controlador
 */
class CategoryController extends Controller
{

    /**
     * index (Muestra todas las categorias)
     * @author Lluís Ferrater
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la lista de categorias
     */
    public function index(Request $request)
    {
        $categories = Category::select('id', 'name')->get();
        return response()->json([
            'status' => '1',
            'categories' => $categories
        ]);
    }

    /**
     * store (Crea una categoria)
     * @author Lluís Ferrater
     * @param StoreCategoriaRequest $request Request con los datos validados de la categoria
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la categoria creada
     */
    public function store(StoreCategoriaRequest $request)
    {

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => '1',
            'message' => 'Categoria creada correctamente',
            'category' => new CategoryResource($category)
        ]);
    }

    /**
     * update (Actualiza una categoria)
     * @author Lluís Ferrater
     * @param StoreCategoriaRequest $request Request con los datos validados de la categoria
     * @param int $id (Id de la categoria a actualizar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la categoria actualizada
     */
    public function update(StoreCategoriaRequest $request, $id)
    {
        $category = Category::find($id);
        $this->compruebaCategoria($category);

        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => '1',
            'message' => 'Categoria actualizada correctamente',
            'category' => new CategoryResource($category)
        ]);
    }

    /**
     * delete (Elimina una categoria)
     * @author Lluís Ferrater
     * @param Request $request
     * @param int $id (Id de la categoria a eliminar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el status y la categoria eliminada
     */
    public function delete(Request $request, $id)
    {
        $category = Category::find($id);
        $this->compruebaCategoria($category);

        $category->delete();

        return response()->json([
            'status' => '1',
            'message' => 'Categoria eliminada correctamente',
            'category' => new CategoryResource($category)
        ]);
    }

    /**
     * compruebaCategoria (Comprueba si una categoria existe)
     * @author Lluís Ferrater
     * @param ?Category $category (Categoria a comprobar)
     * @return \Illuminate\Http\JsonResponse Respuesta JSON abortando si no existe
     */
    private function compruebaCategoria($category)
    {
        if (!$category) {
            abort(response()->json([
                'status' => '0',
                'message' => 'Categoria no encontrada'
            ], 404));
        }
    }
}
