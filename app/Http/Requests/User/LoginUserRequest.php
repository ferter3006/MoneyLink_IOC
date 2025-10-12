<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser una cadena de caracteres',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ];
    }
}
