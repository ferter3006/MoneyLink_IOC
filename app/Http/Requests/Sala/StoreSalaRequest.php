<?php

namespace App\Http\Requests\Sala;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSalaRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:45',
                Rule::unique('salas')->where(function ($query) use ($user) {
                    return $query->where('user_id', $user->id);
                })
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no debe tener más de 45 caracteres',
            'name.unique' => 'Ya tienes una sala con este nombre, se un poco más original!',
        ];
    }
}
