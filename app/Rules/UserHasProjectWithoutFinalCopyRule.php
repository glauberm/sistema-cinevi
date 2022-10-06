<?php

namespace App\Rules;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Validation\InvokableRule;

class UserHasProjectWithoutFinalCopyRule implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private readonly UserService $userService)
    {
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
        /** @var User $user */
        $user = $this->userService->get(\intval($value), ['projects']);

        // foreach ($user->projects as $project) {
        //     if ($project->finalCopy->exists()) {
        //         $fail("O {$attribute} deve ser você mesmo.");
        //     }
        // }
    }
}
