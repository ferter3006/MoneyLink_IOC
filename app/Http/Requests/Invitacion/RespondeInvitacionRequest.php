<?php

namespace App\Http\Requests\Invitacion;

use App\Rules\InvitacionEsParaTi;
use Illuminate\Foundation\Http\FormRequest;

class RespondeInvitacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'id' => [
                'bail',
                'required',
                'exists:invitacions,id',
                new InvitacionEsParaTi(
                    $this->route('id'),
                    request()->get('userFromMiddleware')->id
                ),
            ],
            'respuesta' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'El id de la invitación es obligatorio.',
            'id.exists' => 'La invitación no existe.',
            'id.InvitacionEsParaTi' => 'No tienes permiso para responder a esta invitación.',
            'respuesta.required' => 'La respuesta es obligatoria.',
            'respuesta.boolean' => 'La respuesta debe ser true o false.',
        ];
    }
}
