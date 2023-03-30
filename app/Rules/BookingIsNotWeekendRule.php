<?php

namespace App\Rules;

use Carbon\CarbonImmutable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BookingIsNotWeekendRule implements ValidationRule
{
    /**
     * @param  string   $value
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (CarbonImmutable::parse($value)->isWeekend()) {
            $fail('A :attribute não pode ser um final de semana.');
        }
    }
}
