<?php

namespace Cinevi\RealizacaoBundle\Authorization\Voter;

use Cinevi\AdminBundle\Authorization\Voter\BaseVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class FuncaoVoter extends BaseVoter
{
    protected $className = 'Cinevi\RealizacaoBundle\Entity\Funcao';

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function create($obj, $user, TokenInterface $token)
    {
        return true;
    }

    protected function edit($obj, $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_FUNCIONARIO'))) {
            return true;
        } else {
            return false;
        }
    }
}