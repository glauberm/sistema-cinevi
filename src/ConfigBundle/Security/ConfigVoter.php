<?php

namespace ConfigBundle\Security;

use AdminBundle\Security\AbstractVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use ConfigBundle\Entity\Config;

class ConfigVoter extends AbstractVoter
{
    protected $className = Config::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
