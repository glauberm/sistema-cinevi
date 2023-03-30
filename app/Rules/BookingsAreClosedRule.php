<?php

namespace App\Rules;

use App\Models\Configuration;
use App\Services\AuthService;
use App\Services\ConfigurationService;
use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BookingsAreClosedRule implements ValidationRule
{
    public function __construct(
        private readonly ConfigurationService $configurationService,
        private readonly AuthService $authService,
        private readonly UserService $userService,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
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
