<?php

namespace App\Security\Almoxarifado;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\EquipamentoHistorico;

class EquipamentoHistoricoVoter extends AbstractVoter
{
    protected $className = EquipamentoHistorico::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
