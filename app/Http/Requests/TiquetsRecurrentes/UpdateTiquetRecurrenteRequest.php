<?php

namespace App\Http\Requests\TiquetsRecurrentes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTiquetRecurrenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        // Solo permitimos modificar: 
        // categoria, es_ingreso, description, amount, recurrencia_es_mensual, recurrencia_dia_activacion
        return [
            'category_id' => [
                'sometimes',
                'integer',
                Rule::exists('categories', 'id')
            ],
            'es_ingreso' => 'sometimes|boolean',
            'description' => 'sometimes|string|max:255',
            'amount' => [
                'sometimes',
                'numeric',
                'min:0.01',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'recurrencia_es_mensual' => 'sometimes|boolean',
            'recurrencia_dia_activacion' => [
                'sometimes',
                'integer',
                'min:1',
                'max:31'
            ]
        ];
    }

    public function messages()
    {
        return [
            'category_id.integer' => 'La categoría debe ser un número entero',
            'category_id.exists' => 'La categoría no existe',
            'es_ingreso.boolean' => 'El campo es_ingreso debe ser un valor booleano',
            'description.string' => 'La descripción debe ser una cadena de caracteres',
            'description.max' => 'La descripción no debe tener más de 255 caracteres',
            'amount.numeric' => 'El monto debe ser un número',
            'amount.min' => 'El monto debe ser mayor a 0.01',
            'amount.regex' => 'El monto debe ser un número con dos decimales maximo 0.01',
            'recurrencia_es_mensual.boolean' => 'El campo recurrencia_es_mensual debe ser un valor booleano',
            'recurrencia_dia_activacion.integer' => 'El campo recurrencia_dia_activacion debe ser un número entero',
            'recurrencia_dia_activacion.min' => 'El campo recurrencia_dia_activacion debe ser mayor a 0',
            'recurrencia_dia_activacion.max' => 'El campo recurrencia_dia_activacion debe ser menor a 32',
        ];
    }
}
