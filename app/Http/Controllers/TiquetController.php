<?php

namespace App\Http\Controllers;

use App\Models\Tiquet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TiquetController extends Controller
{
    public function create(Request $request)
    {
        $userFromMiddleware = $request->get('userFromMiddleware');

        $request->validate([
            'sala_id' => [
                'required',
                'integer',
                Rule::exists('user_sala_roles', 'sala_id')
                    ->where('user_id', $userFromMiddleware->id)
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
            ],
            'es_ingreso' => 'required|boolean',
            'description' => 'required|string|max:255',
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'regex:/^\d+(\.\d{1,2})?$/'
            ]

        ], [
            'sala_id.required' => 'La sala es requerida',
            'sala_id.integer' => 'La sala debe ser un número entero',
            'sala_id.exists' => 'La sala no existe',
            'category_id.required' => 'La categoría es requerida',
            'category_id.integer' => 'La categoría debe ser un número entero',
            'category_id.exists' => 'La categoría no existe',
            'es_ingreso.required' => 'El tipo de tiquet es requerido',
            'es_ingreso.boolean' => 'El tipo de tiquet debe ser un booleano',
            'amount.required' => 'El monto es requerido',
            'amount.decimal' => 'El monto debe ser un número decimal con dos decimales 0.01',
            'amount.min' => 'El monto debe ser mayor a 0.01',
        ]);

        $tiquet = Tiquet::create([
            'user_id' => $userFromMiddleware->id,
            'sala_id' => $request->input('sala_id'),
            'category_id' => $request->input('category_id'),
            'es_ingreso' => $request->input('es_ingreso'),
            'description' => $request->input('description'),
            'amount' => $request->input('amount')
        ]);

        return response()->json([
            'status' => '1',
            'message' => 'Tiquet creado correctamente',
            'tiquet' => $tiquet
        ]);
    }
}
