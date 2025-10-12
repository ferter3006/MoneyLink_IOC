<?php

namespace App\Http\Requests\Tiquets;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTiquetRequest extends FormRequest
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
        // Solo permitimos modificar categoria, es_ingreso, description y amount
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
            ]

        ];
    }

    public function messages(): array
    {
        return [
            'category_id.integer' => 'La categoría debe ser un número entero',
            'category_id.exists' => 'La categoría no existe',
            'es_ingreso.boolean' => 'El tipo de tiquet debe ser un booleano',
            'amount.decimal' => 'El monto debe ser un número decimal con dos decimales 0.01',
            'amount.min' => 'El monto debe ser mayor a 0.01',
            'amount.regex' => 'El monto debe ser un número decimal con dos decimales maximo 0.01'
        ];
    }
}
