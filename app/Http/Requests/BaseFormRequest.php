<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class BaseFormRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        Log::warning('Input validation failed for ' . $this->url() . ':', [
            'user_id' => $this->user() ? $this->user()->id : 'guest',
            'ip_address' => $this->ip(),
            'input' => $this->all(),
            'errors' => $validator->errors()->toArray(),
        ]);

        throw new ValidationException($validator);
    }
}
