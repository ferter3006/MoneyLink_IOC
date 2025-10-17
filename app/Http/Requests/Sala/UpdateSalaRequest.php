<?php

namespace App\Http\Requests\Sala;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de actualizacion de salas
 * @author Lluís Ferrater
 * @version 1.0
 */
class UpdateSalaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get de las reglas de validacion de la sala
     * @author Lluís Ferrater
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:45|min:3',
        ];
    }

    /**
     * Get de los mensajes de error de la sala
     * @author Lluís Ferrater
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no debe tener más de 45 caracteres',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
        ];
    }
}
