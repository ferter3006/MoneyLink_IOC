<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class InvitacionUnica implements ValidationRule
{
    protected string $userInvitadoEmail;
    protected int $salaId;

    public function __construct(string $emailInvitado, int $salaId)
    {
        $this->userInvitadoEmail = $emailInvitado;
        $this->salaId = $salaId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userInvitadoId = User::where('email', $this->userInvitadoEmail)->value('id');

        $unique = DB::table('invitacions')
            ->where('user_invitado_id', $userInvitadoId)
            ->where('sala_id', $this->salaId)
            ->exists();

        if ($unique) {
            $fail('Ya has invitado a este usuario a esta sala.');
        }
    }
}
