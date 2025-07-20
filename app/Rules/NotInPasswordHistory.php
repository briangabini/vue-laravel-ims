<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class NotInPasswordHistory implements ValidationRule
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->user->passwordHistories as $passwordHistory) {
            if (Hash::check($value, $passwordHistory->password_hash)) {
                $fail('You cannot reuse a previous password.');
            }
        }
    }
}
