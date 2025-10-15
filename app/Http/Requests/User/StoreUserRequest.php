<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de creación de usuarios
 * @author Lluís Ferrater
 * @version 1.0
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get de las reglas de validacion del request de creacion de los usuarios
     * @author Lluís Ferrater
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // Al menos una letra mayúscula
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Al menos un carácter especial
            ],
        ];
    }

    /**
     * Get de los mensajes de error sobre las reglas de validacion de creacion de los usuarios
     * @author Lluís Ferrater
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El campo name es obligatorio.',
            'name.string' => 'El campo name debe ser una cadena de caracteres.',
            'name.max' => 'El campo name no debe tener más de 255 caracteres.',
            'name.min' => 'El campo name debe tener al menos 3 caracteres.',
            'email.required' => 'El campo email es obligatorio.',
            'email.string' => 'El campo email debe ser una cadena de caracteres.',
            'email.max' => 'El campo email no debe tener más de 255 caracteres.',
            'email.unique' => 'El email ya está en uso.',
            'password.string' => 'El campo password debe ser una cadena de caracteres.',
            'password.required' => 'El campo password es obligatorio.',
            'password.min' => 'El campo password debe tener al menos 8 caracteres.',
            'password.regex' => 'El campo password debe tener al menos una letra mayúscula y un carácter especial.',
        ];
    }
}
