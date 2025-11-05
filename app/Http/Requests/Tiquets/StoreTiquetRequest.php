<?php

namespace App\Http\Requests\Tiquets;

use App\Rules\YourAreInSala;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request de creacion de tiquets
 * Class StoreTiquetRequest.
 * @author Lluís Ferrater
 * @version 1.0
 */
class StoreTiquetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get de las reglas de validacion de los tiquets
     * @author Lluís Ferrater
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = $this->get('userFromMiddleware');

        return [
            'sala_id' => [
                'bail',
                'required',
                'integer',                
                Rule::exists('user_sala_roles', 'sala_id')
                    ->where('user_id', $user->id)
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
        ];
    }

    /**
     * Get de los mensajes de error sobre las reglas de validacion de los tiquets
     * @author Lluís Ferrater
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sala_id.required' => 'La sala es requerida',
            'sala_id.integer' => 'La sala debe ser un número entero',
            'sala_id.exists' => 'La sala no existe o no pertenece al usuario',
            'category_id.required' => 'La categoría es requerida',
            'category_id.integer' => 'La categoría debe ser un número entero',
            'category_id.exists' => 'La categoría no existe',
            'es_ingreso.required' => 'El tipo de tiquet es requerido',
            'es_ingreso.boolean' => 'El tipo de tiquet debe ser un booleano',
            'amount.required' => 'El monto es requerido',
            'amount.min' => 'El monto debe ser mayor a 0.01',
        ];
    }
}
