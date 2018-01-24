<?php

namespace App\Security\Almoxarifado;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\CategoriaHistorico;

class CategoriaHistoricoVoter extends AbstractVoter
{
    protected $className = CategoriaHistorico::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
