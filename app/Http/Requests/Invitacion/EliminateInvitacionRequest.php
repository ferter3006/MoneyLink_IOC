<?php

namespace App\Http\Requests\Invitacion;

use App\Rules\InvitacionEsTuya;
use Illuminate\Foundation\Http\FormRequest;

class EliminateInvitacionRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->get('userFromMiddleware')->id;

        return [
            'id' => [
                'bail',
                'required',
                'exists:invitacions,id',
                // Verifica que la invitación pertenece al usuario autenticado
                new InvitacionEsTuya($this->id, $userId),
            ]

        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'El ID de la invitación es obligatorio.',
            'id.exists' => 'La invitación especificada no existe.',
            'id.InvitacionEsTuya' => 'No tienes permiso para eliminar esta invitación.',
        ];
    }
}
