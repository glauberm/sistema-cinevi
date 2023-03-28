<?php

namespace App\Rules;

use App\Services\AuthService;
use App\Services\ProjectService;
use App\Services\UserService;
use Illuminate\Contracts\Validation\InvokableRule;

class UserOwnsProject implements InvokableRule
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService,
        private readonly ProjectService $projectService
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  int  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $authUser = $this->authService->getAuthUserOrFail();

        if (
            $this->userService->isOrdinary($authUser)
            && $this->projectService->isOwnedBy($value, $authUser)
        ) {
            $fail(
                "O {$attribute} deve ser um projeto cujo responsável seja você."
            );
        }
    }
}
