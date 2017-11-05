<?php

namespace Cinevi\RealizacaoBundle\Authorization\Voter;

use Cinevi\AdminBundle\Authorization\Voter\BaseVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class CopiaFinalVoter extends BaseVoter
{
    protected $className = 'Cinevi\RealizacaoBundle\Entity\CopiaFinal';

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function view($obj, $user, TokenInterface $token)
    {
        return true;
    }

    protected function create($obj, $user, TokenInterface $token)
    {
        return true;
    }

    protected function edit($obj, $user, TokenInterface $token)
    {
        if (($this->decisionManager->decide($token, array('ROLE_DEPARTAMENTO'))) || ($obj->getRealizacao()->getUser() === $user && $user->getConfirmado() === true)) {
            return true;
        } else {
            return false;
        }
    }
}
