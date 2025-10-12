<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categorias\StoreCategoriaRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index(Request $request)
    {

        $categories = Category::select('id', 'name')->get();

        return response()->json([
            'status' => '1',
            'categories' => $categories
        ]);
    }


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
