<?php

namespace App\Security\Realizacao;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\FuncaoHistorico;

class FuncaoHistoricoVoter extends AbstractVoter
{
    protected $className = FuncaoHistorico::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
