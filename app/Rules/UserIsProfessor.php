<?php

namespace App\Rules;

use App\Enums\UserRole;
use App\Services\AuthService;
use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserIsProfessor implements ValidationRule
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $authUser = $this->authService->getAuthUserOrFail();

        if (!$this->userService->hasRole($authUser, UserRole::Professor)) {
            $fail('O :attribute deve ser um professor.');
        }
    }
}
