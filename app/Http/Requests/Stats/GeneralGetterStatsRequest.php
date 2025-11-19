<?php

namespace App\Http\Requests\Stats;

use App\Models\UserSalaRole;
use Illuminate\Foundation\Http\FormRequest;

class GeneralGetterStatsRequest extends FormRequest
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
            'salaId' => $this->route('salaId'),
            'm' => $this->route('m')
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
            'salaId' => ['required', 'integer', 'exists:salas,id'],
            'm' => ['required', 'integer']
        ];
    }

    public function youAreInSala(): void
    {
        $salaId = $this->route('salaId');
        $user = $this->get('userFromMiddleware');

        if (UserSalaRole::where('user_id', $user->id)->where('sala_id', $salaId)->doesntExist()) {
            $this->failedAuthorization();
        }

    }
}
