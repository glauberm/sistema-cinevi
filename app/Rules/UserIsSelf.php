<?php

namespace App\Rules;

use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Contracts\Validation\InvokableRule;

class UserIsSelf implements InvokableRule
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserService $userService
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
        $authUser = $this->authService->getAuthUserOrFail();

        if (
            $this->userService->isOrdinary($authUser)
            && $authUser->id !== $value
        ) {
            $fail("O {$attribute} deve ser você mesmo.");
        }
    }
}
