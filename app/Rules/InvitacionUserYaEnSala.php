<?php

namespace App\Rules;

use App\Models\User;
use App\Models\UserSalaRole;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InvitacionUserYaEnSala implements ValidationRule
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

        $exists = UserSalaRole::where('user_id', $userInvitadoId)
            ->where('sala_id', $this->salaId)
            ->exists();

        if ($exists) {
            $fail('El usuario ya está en la sala, no es necesario invitarlo.');
        }
    }
}
