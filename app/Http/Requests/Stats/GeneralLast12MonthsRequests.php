<?php

namespace App\Http\Requests\Stats;

use App\Models\UserSalaRole;
use Illuminate\Foundation\Http\FormRequest;

class GeneralLast12MonthsRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->youAreInSala();
        return true;
    }
    /**
     * Prepara los datos para la validación, incluyendo los route params.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'salaId' => $this->route('salaId')            
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
            'salaId' => ['required', 'integer', 'exists:salas,id']
        ];
    }

    public function youAreInSala()
    {
        $salaId = $this->route('salaId');
        $user = $this->get('userFromMiddleware');

        if (UserSalaRole::where('user_id', $user->id)->where('sala_id', $salaId)->doesntExist()) {
            response()->json([
                'status' => 0,
                'message' => 'No eres miembro de esta sala.'
            ], 403)->send();
            exit;
        }

    }
}
