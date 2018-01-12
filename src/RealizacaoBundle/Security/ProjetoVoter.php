<?php

namespace RealizacaoBundle\Security;

use AdminBundle\Security\AbstractVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class ProjetoVoter extends AbstractVoter
{
    protected $className = 'RealizacaoBundle\Entity\Projeto';

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
        if (($this->decisionManager->decide($token, array('ROLE_DEPARTAMENTO'))) || ($obj->getRealizacao()->getUser() === $user)) {
            return true;
        } else {
            return false;
        }
    }
}
