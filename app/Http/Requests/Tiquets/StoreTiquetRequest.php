<?php

namespace App\Http\Requests\Tiquets;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
            ]
        ];
    }

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
