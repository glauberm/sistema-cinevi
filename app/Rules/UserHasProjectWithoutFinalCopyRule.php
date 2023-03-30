<?php

namespace App\Rules;

use App\Models\User;
use App\Services\UserService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserHasProjectWithoutFinalCopyRule implements ValidationRule
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var User $user */
        $user = $this->userService->get(intval($value), ['projects']);

        foreach ($user->projects as $project) {
            if ($project->finalCopy->exists()) {
                $fail(
                    'O :attribute não pode possuir um projeto sem cópia final.'
                );
            }
        }
    }
}
