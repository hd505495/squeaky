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
        $profanities = Config::get('profanify-'.Config::get('app.locale'));
        $tolerated = Config::get('profanify-tolerated');

        if (Str::contains(Str::remove($tolerated, $value), $profanities)) {
            $fail('The :attribute is not clean.');
        }
    }
}
