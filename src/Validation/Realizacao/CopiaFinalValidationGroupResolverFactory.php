<?php

namespace App\Validation\Realizacao;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CopiaFinalValidationGroupResolverFactory
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function create()
    {
        $copiaFinalValidationGroupResolver = new CopiaFinalValidationGroupResolver($this->authorizationChecker);

        return $copiaFinalValidationGroupResolver;
    }
}
