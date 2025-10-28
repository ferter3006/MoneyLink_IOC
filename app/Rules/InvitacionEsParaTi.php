<?php

namespace App\Rules;

use App\Models\Invitacion;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InvitacionEsParaTi implements ValidationRule
{
    protected int $invitacionId;
    protected int $userId;

    public function __construct(int $invitacionId, int $userId)
    {
        $this->invitacionId = $invitacionId;
        $this->userId = $userId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $invitacion = Invitacion::where('id', $this->invitacionId)
            ->where('user_invitado_id', $this->userId)
            ->first();

        if (!$invitacion) {
            $fail('Esta invitación no te pertenece.');
        }
    }
}
