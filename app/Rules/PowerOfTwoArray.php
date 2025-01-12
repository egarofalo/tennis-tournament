<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PowerOfTwoArray implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $count = count($value);

        if ($count < 2) {
            $fail('The :attribute array must have two or more elements');
        }

        if (($count & ($count - 1)) !== 0) {
            $fail('The :attribute array must have a number of elements that is a power of 2');
        }
    }
}
