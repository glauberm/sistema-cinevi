<?php

namespace App\Validation\User;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserValidationGroupResolverFactory
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function create()
    {
        $userValidationGroupResolver = new UserValidationGroupResolver($this->authorizationChecker);

        return $userValidationGroupResolver;
    }
}
