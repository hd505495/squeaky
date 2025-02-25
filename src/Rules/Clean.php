<?php

namespace JonPurvis\Clean\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Clean implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Str::contains(strtolower($value), Config::get('profanify-en'))) {
            $fail('The :attribute is not clean.');
        }
    }
}
