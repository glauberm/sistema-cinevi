<?php

namespace Cinevi\RealizacaoBundle\Validation;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RealizacaoValidationGroupResolver
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function __invoke(FormInterface $form)
    {
        $groups = array('Default');

        if($this->tokenStorage->getToken()->getUser()->getProfessor() !== true) {
            array_push($groups, 'notProfessor');
        }

        return $groups;
    }
}
