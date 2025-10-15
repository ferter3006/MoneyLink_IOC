<?php

namespace App\Http\Requests\Categorias;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de creacion de categorias
 * @author Lluís Ferrater
 * @version 1.0
 */
class StoreCategoriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**     
     * Get de las reglas de validacion de la categoria
     * @author Lluís Ferrater
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:categories,name|string|max:255|min:3',
        ];
    }

    /**
     * Get de los mensajes de error de la categoria
     * @author Lluís Ferrater
     * @return array<string, string>
     */
    public function messages()
    {
        return
            [
                'name.required' => 'El nombre es requerido',
                'name.unique' => 'Esta categoria ya existe',
                'name.string' => 'El nombre debe ser una cadena de caracteres',
                'name.max' => 'El nombre no puede tener más de 255 caracteres',
                'name.min' => 'El nombre debe tener al menos 3 caracteres',
            ];
    }
}
