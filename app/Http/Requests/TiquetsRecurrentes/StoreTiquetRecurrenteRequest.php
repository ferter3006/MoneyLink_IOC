<?php

namespace App\Http\Requests\TiquetsRecurrentes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request de creacion de tiquets recurrentes
 * @author Lluís Ferrater
 * @version 1.0
 */
class StoreTiquetRecurrenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get de las reglas de validacion de los tiquets recurrentes
     * @author Lluís Ferrater
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = $this->get('userFromMiddleware');

        return [
            'sala_id' => [
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
            ],
            'recurrencia_es_mensual' => 'required|boolean',
            'recurrencia_dia_activacion' => [
                'required',
                'integer',
                'min:1',
                'max:31'
            ]
        ];
    }

    /**
     * Get de los mensajes de error sobre las reglas de validacion de los tiquets recurrentes
     * @author Lluís Ferrater
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'sala_id.required' => 'La sala es requerida',
            'sala_id.integer' => 'La sala debe ser un número entero',
            'sala_id.exists' => 'La sala no existe o no tienes permiso para acceder a ella',
            'category_id.required' => 'La categoria es requerida',
            'es_ingreso.required' => 'El tipo es requerido',
            'description.required' => 'La descripcion es requerida',
            'amount.required' => 'El monto es requerido',
            'recurrencia_es_mensual.required' => 'La recurrencia_es_mensual es requerida',
            'recurrencia_dia_activacion.required' => 'La recurrencia_dia_activacion es requerido',
        ];
    }
}
