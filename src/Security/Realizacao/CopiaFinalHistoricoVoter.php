<?php

namespace App\Security\Realizacao;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\CopiaFinalHistorico;

class CopiaFinalHistoricoVoter extends AbstractVoter
{
    protected $className = CopiaFinalHistorico::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
