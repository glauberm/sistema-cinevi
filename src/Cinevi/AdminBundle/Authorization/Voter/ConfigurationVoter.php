<?php

namespace Cinevi\AdminBundle\Authorization\Voter;

use Cinevi\AdminBundle\Authorization\Voter\BaseVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class ConfigurationVoter extends BaseVoter
{
    protected $className = 'Cinevi\AdminBundle\Entity\Configuration';

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
}
