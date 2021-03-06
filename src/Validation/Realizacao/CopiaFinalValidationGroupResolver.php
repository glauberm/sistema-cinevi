<?php

namespace App\Validation\Realizacao;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CopiaFinalValidationGroupResolver
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function __invoke(FormInterface $form)
    {
        $groups = array('Default');

        if($this->authorizationChecker->isGranted('ROLE_DEPARTAMENTO')) {
            array_push($groups, 'departamento');
        }

        return $groups;
    }
}
