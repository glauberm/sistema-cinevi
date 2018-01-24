<?php

namespace App\Security\Almoxarifado;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\CalendarEventHistorico;

class CalendarEventHistoricoVoter extends AbstractVoter
{
    protected $className = CalendarEventHistorico::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
