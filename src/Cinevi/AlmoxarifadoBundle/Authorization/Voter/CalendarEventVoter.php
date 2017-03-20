<?php

namespace Cinevi\AlmoxarifadoBundle\Authorization\Voter;

use Doctrine\ORM\EntityManager;
use Cinevi\AdminBundle\Authorization\Voter\BaseVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class CalendarEventVoter extends BaseVoter
{
    protected $className = 'Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent';

    public function __construct(AccessDecisionManagerInterface $decisionManager, EntityManager $em)
    {
        $this->decisionManager = $decisionManager;
        $this->em = $em;
    }

    protected function view($obj, $user, TokenInterface $token)
    {
        return true;
    }

    protected function create($obj, $user, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, array('ROLE_ALMOXARIFADO'))) {
            return true;
        } else {
            $config = $this->em->getRepository('CineviAdminBundle:Configuration')
                ->createQueryBuilder('config')
                ->getQuery()
                ->getOneOrNullResult()
            ;

            if($config && $config->getReservasFechadas() === true) {
                if($user->getProfessor() === true) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }

    protected function edit($obj, $user, TokenInterface $token)
    {
        if (($this->decisionManager->decide($token, array('ROLE_ALMOXARIFADO'))) || ($obj->getUser() === $user)) {
            return true;
        } else {
            return false;
        }
    }

    protected function delete($obj, $user, TokenInterface $token)
    {
        if (($this->decisionManager->decide($token, array('ROLE_ALMOXARIFADO'))) || ($obj->getUser() === $user)) {
            return true;
        } else {
            return false;
        }
    }
}
