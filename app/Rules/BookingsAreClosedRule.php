<?php

namespace App\Rules;

use App\Models\Configuration;
use App\Services\AuthService;
use App\Services\ConfigurationService;
use App\Services\UserService;
use Illuminate\Contracts\Validation\InvokableRule;

class BookingsAreClosedRule implements InvokableRule
{
    public function __construct(
        private readonly ConfigurationService $configurationService,
        private readonly AuthService $authService,
        private readonly UserService $userService,
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        /** @var Configuration $configuration */
        $configuration = $this->configurationService->get(1);

        $authUser = $this->authService->getAuthUserOrFail();

        if (
            $configuration->bookings_are_closed
            && $this->userService->isOrdinary($authUser)
        ) {
            $fail('As reservas estão fechadas para alunos.');
        }
    }
}
