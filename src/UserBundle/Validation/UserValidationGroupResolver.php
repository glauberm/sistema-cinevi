<?php

namespace UserBundle\Validation;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserValidationGroupResolver
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function __invoke(FormInterface $form)
    {
        $groups = array('Default');

        if(!$form->getData()->getId()) {
            array_push($groups, 'new');
        }

        if($this->authorizationChecker->isGranted('ROLE_DEPARTAMENTO')) {
            array_push($groups, 'departamento');
        }

        if($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            array_push($groups, 'superAdmin');
        }

        return $groups;
    }
}
