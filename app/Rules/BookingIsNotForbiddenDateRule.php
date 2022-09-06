<?php

namespace App\Rules;

use App\Models\Configuration;
use App\Services\ConfigurationService;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\InvokableRule;

class BookingIsNotForbiddenDateRule implements InvokableRule
{
    private ConfigurationService $configurationService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(ConfigurationService $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    /**
     * Run the validation rule.
     *
     * @param  string    $attribute
     * @param  string    $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $valueDate = CarbonImmutable::parse($value);

        /** @var Configuration $configuration */
        $configuration = $this->configurationService->get(1);

        foreach ($configuration->bookings_forbidden_dates as $forbiddenDate) {
            if (
                $valueDate->month === \intval($forbiddenDate['month']) &&
                $valueDate->day === \intval($forbiddenDate['day'])
            ) {
                $fail('A :attribute não pode ser realizada na data de ' . $forbiddenDate['name']);
            }
        }
    }
}
