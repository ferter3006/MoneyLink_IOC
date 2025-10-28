<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class YourAreInSala implements ValidationRule
{
    protected int $userId;

    public function __construct(int $id)
    {
        $this->userId = $id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    /**
     * Valido que el usuario autenticado esté en la sala especificada.
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $exists = DB::table('user_sala_roles')
            ->where('user_id', $this->userId)
            ->where('sala_id', $value)
            ->exists();

        if (!$exists) {
            $fail('No estas en la sala especificada.');
        }
    }
}
