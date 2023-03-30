<?php

namespace App\Rules;

use App\Services\AuthService;
use App\Services\ProjectService;
use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserOwnsProject implements ValidationRule
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService,
        private readonly ProjectService $projectService
    ) {
    }

    /**
     * @param  int  $value
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $authUser = $this->authService->getAuthUserOrFail();

        if (
            $this->userService->isOrdinary($authUser)
            && $this->projectService->isOwnedBy($value, $authUser)
        ) {
            $fail(
                'O :attribute deve ser um projeto cujo responsável seja você.'
            );
        }
    }
}
