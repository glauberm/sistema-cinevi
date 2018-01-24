<?php

namespace App\Security\Realizacao;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\ProjetoHistorico;

class ProjetoHistoricoVoter extends AbstractVoter
{
    protected $className = ProjetoHistorico::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
