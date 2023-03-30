<?php

namespace App\Rules;

use App\Models\Configuration;
use App\Services\ConfigurationService;
use Carbon\CarbonImmutable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BookingIsNotForbiddenDateRule implements ValidationRule
{
    public function __construct(private readonly ConfigurationService $configurationService)
    {
    }

    /**
     * @param  string   $value
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $valueDate = CarbonImmutable::parse($value);

        /** @var Configuration $configuration */
        $configuration = $this->configurationService->get(1);

        foreach ($configuration->bookings_forbidden_dates as $forbiddenDate) {
            if (
                $valueDate->month === intval($forbiddenDate['month']) &&
                $valueDate->day === intval($forbiddenDate['day'])
            ) {
                $fail(
                    "A :attribute não pode ser realizada na data de {$forbiddenDate['name']}."
                );
            }
        }
    }
}
