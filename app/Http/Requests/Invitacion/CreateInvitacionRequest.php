<?php

namespace App\Http\Requests\Invitacion;

use App\Models\User;
use App\Rules\InvitacionNotYou;
use App\Rules\InvitacionUnica;
use App\Rules\InvitacionUserYaEnSala;
use App\Rules\YourAreInSala;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateInvitacionRequest extends FormRequest
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
            'email_invitado' => [
                'bail',
                'required',
                'exists:users,email',
                new InvitacionNotYou($this->input('email_invitado'), $userFromMiddleware->id),
                new InvitacionUserYaEnSala($this->input('email_invitado'), $this->input('sala_id')),
                new InvitacionUnica($this->input('email_invitado'), $this->input('sala_id')),
            ],
            'sala_id' => [
                'required',
                'exists:salas,id',
                new YourAreInSala($userFromMiddleware->id),
            ]
        ];
    }

    public function messages()
    {
        return [
            'email_invitado.required' => 'El email del invitado es obligatorio.',
            'email_invitado.exists' => 'El email del invitado no existe en el sistema.',
            'sala_id.required' => 'El ID de la sala es obligatorio.',
            'sala_id.exists' => 'La sala especificada no existe.',
            'sala_id.YouAreInSala' => 'No tienes permiso para invitar usuarios a esta sala.',
        ];
    }
}
