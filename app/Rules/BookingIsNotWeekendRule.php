<?php

namespace App\Rules;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\InvokableRule;

class BookingIsNotWeekendRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (CarbonImmutable::parse($value)->isWeekend()) {
            $fail('A :attribute não pode ser um final de semana.');
        }
    }
}
