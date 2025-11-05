<?php

namespace App\Http\Requests\Sala;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalaRequestWithInvitationsRequest extends FormRequest
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
        $userFromMiddleware = request()->get('userFromMiddleware');

        return [
            'name' => 'required|string|max:255',
            'invitaciones' => 'required|array',
            'invitaciones.*.email' => [
                'bail',
                'required',
                'email',
                'exists:users,email',
                'distinct',
                new \App\Rules\InvitacionNotYou($userFromMiddleware->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no debe tener más de 255 caracteres',
            'invitaciones.required' => 'Las invitaciones son requeridas',
            'invitaciones.array' => 'Las invitaciones deben ser un array de emails',
            'invitaciones.*.email.required' => 'El email es requerido (invitaciones debe ir en formato {"email": "<email>"})',
            'invitaciones.*.email.email' => 'El email debe ser una dirección de correo electrónico válida',
            'invitaciones.*.email.exists' => 'El email no existe en el sistema',
            'invitaciones.*.email.distinct' => 'No se permiten emails duplicados en las invitaciones',
        ];
    }
}
