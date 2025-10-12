<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Exists;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255|min:3',
            'email' => 'sometimes|string|email|max:255|unique:users,email,{$user->id}',
            'password' => [
                'sometimes',
                'string',
                'min:8',
                'regex:/[A-Z]/',      // Al menos una letra mayúscula
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Al menos un carácter especial  
            ],
            'role_id' => [
                'sometimes',
                'integer',
                'in:1,2',
                'exists:roles,id',
                    
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no debe tener más de 255 caracteres',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'email.string' => 'El email debe ser una cadena de caracteres',
            'email.email' => 'El email no es válido',
            'email.max' => 'El email no debe tener más de 255 caracteres',
            'email.unique' => 'El email ya está en uso',
            'password.string' => 'La contraseña debe ser una cadena de caracteres',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.regex' => 'La contraseña debe tener al menos una letra mayúscula y un carácter especial',
            'role_id.integer' => 'El rol debe ser un número entero',            
            'role_id.exists' => 'El rol no existe',
        ];
    }
}
