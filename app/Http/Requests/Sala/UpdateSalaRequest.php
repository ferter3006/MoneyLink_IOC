<?php

namespace App\Http\Requests\Sala;

use Illuminate\Foundation\Http\FormRequest;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'name' => 'string|max:45|min:3',                       
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no debe tener más de 45 caracteres',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
        ];
    }
}
