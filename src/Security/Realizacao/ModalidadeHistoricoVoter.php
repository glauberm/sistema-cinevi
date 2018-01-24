<?php

namespace App\Security\Realizacao;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\ModalidadeHistorico;

class ModalidadeHistoricoVoter extends AbstractVoter
{
    protected $className = ModalidadeHistorico::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
