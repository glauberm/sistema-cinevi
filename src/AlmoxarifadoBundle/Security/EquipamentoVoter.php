<?php

namespace AlmoxarifadoBundle\Security;

use AdminBundle\Security\AbstractVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class EquipamentoVoter extends AbstractVoter
{
    protected $className = 'AlmoxarifadoBundle\Entity\Equipamento';

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
        if ($this->decisionManager->decide($token, array('ROLE_ALMOXARIFADO'))) {
            return true;
        } else {
            return false;
        }
    }

    protected function edit($obj, $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_ALMOXARIFADO')) || $this->decisionManager->decide($token, array('ROLE_DEPARTAMENTO'))) {
            return true;
        } else {
            return false;
        }
    }
}
