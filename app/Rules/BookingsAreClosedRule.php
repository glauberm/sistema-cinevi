<?php

namespace App\Rules;

use App\Models\Configuration;
use App\Models\User;
use App\Services\ConfigurationService;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Auth;

class BookingsAreClosedRule implements InvokableRule
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
        /** @var Configuration $configuration */
        $configuration = $this->configurationService->get(1);

        /** @var User $user */
        $user = Auth::user();

        if (
            $configuration->bookings_are_closed === true &&
            (!\in_array('admin', $user->roles) ||
                !\in_array('warehouse', $user->roles) ||
                !\in_array('department', $user->roles) ||
                !\in_array('professor', $user->roles))
        ) {
            $fail('As reservas estão fechadas para alunos.');
        }
    }
}
