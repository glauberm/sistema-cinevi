<?php

namespace App\Rules;

use App\Services\AuthService;
use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserIsSelf implements ValidationRule
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $authUser = $this->authService->getAuthUserOrFail();

        if (
            $this->userService->isOrdinary($authUser)
            && $authUser->id !== $value
        ) {
            $fail('O :attribute deve ser você mesmo.');
        }
    }
}
