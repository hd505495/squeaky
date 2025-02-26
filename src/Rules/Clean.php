<?php

namespace JonPurvis\Clean\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Clean implements ValidationRule
{
    public function __construct(
        public ?array $locales = [],
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $locales = empty($this->locales) ? [Config::get('app.locale')] : $this->locales;

        foreach ($locales as $locale) {
            $profanities = Config::get('profanify-'.$locale);
            $tolerated = Config::get('profanify-tolerated');

            if (Str::contains(Str::lower(Str::remove($tolerated, $value)), $profanities)) {
                $fail(trans('clean::validation.clean'))->translate([
                    'attribute' => $attribute,
                ], $locale);
            }
        }
    }
}
