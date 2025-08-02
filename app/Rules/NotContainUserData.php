<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class NotContainUserData implements ValidationRule
{
    /**
     * The user's data to check against.
     *
     * @var array
     */
    protected $userData;

    /**
     * Create a new rule instance.
     *
     * @param  array  $userData
     * @return void
     */
    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $password = Str::lower($value);

        foreach ($this->userData as $data) {
            $data = Str::lower($data);
            if (Str::contains($password, $data)) {
                $fail('The :attribute must not contain your name or email.');
            }
        }
    }
}