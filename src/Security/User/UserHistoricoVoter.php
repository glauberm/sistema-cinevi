<?php

namespace App\Security\User;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\UserHistorico;

class UserHistoricoVoter extends AbstractVoter
{
    protected $className = UserHistorico::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
