<?php

namespace JonPurvis\Squeaky\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Clean implements ValidationRule
{
    public function __construct(
        public ?array $locales = [],
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $locales = empty($this->locales) ? [Config::get('app.locale')] : $this->locales;

        $this->ensureLocalesAreValid($locales);

        foreach ($locales as $locale) {
            $profanities = Config::get('profanify-' . $locale);
            $tolerated = Config::get('profanify-tolerated');

            if (Str::contains(Str::lower(Str::remove($tolerated, $value)), $profanities)) {
                $fail(trans('message'))->translate([
                    'attribute' => $attribute,
                ], $locale);
            }
        }
    }

    /**
     * Check that a config file exists for each locale. If one of the locales
     * is invalid, then throw an exception.
     */
    protected function ensureLocalesAreValid(array $locales): void
    {
        foreach ($locales as $locale) {
            if (!is_string($locale)) {
                throw new InvalidArgumentException('The locale must be a string.');
            }

            if (!Config::has('profanify-' . $locale)) {
                throw new InvalidArgumentException("The locale ['{$locale}'] is not supported.");
            }
        }
    }
}
