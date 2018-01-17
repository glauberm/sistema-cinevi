<?php

namespace App\Security\Config;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\Config;

class ConfigVoter extends AbstractVoter
{
    protected $className = Config::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
