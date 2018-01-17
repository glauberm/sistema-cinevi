<?php

namespace App\Security\Realizacao;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\CopiaFinal;

class CopiaFinalVoter extends AbstractVoter
{
    protected $className = CopiaFinal::class;

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
