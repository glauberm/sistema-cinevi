<?php

namespace Cinevi\ConfigBundle\Authorization\Voter;

use Cinevi\AdminBundle\Authorization\Voter\BaseVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class ConfigVoter extends BaseVoter
{
    protected $className = 'Cinevi\ConfigBundle\Entity\Config';

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
