<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InvitacionNotYou implements ValidationRule
{

    protected string $userInvitadoEmail;
    protected int $userId;

    public function __construct(string $emailInvitado, int $userId)
    {
        $this->userInvitadoEmail = $emailInvitado;
        $this->userId = $userId;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    /**
     * Valido que el email del invitado no sea el mismo que el del usuario autenticado.
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $Exists = User::where('email', $this->userInvitadoEmail)
            ->where('id', $this->userId)
            ->exists();

        if ($Exists) {
            $fail('No puedes invitarte a ti mismo.');
        }
    }
}
