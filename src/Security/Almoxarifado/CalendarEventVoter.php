<?php

namespace App\Security\Almoxarifado;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use App\Security\Admin\AbstractVoter;
use App\Entity\CalendarEvent;
use App\Entity\Config;

class CalendarEventVoter extends AbstractVoter
{
    protected $className = CalendarEvent::class;

    public function __construct(AccessDecisionManagerInterface $decisionManager, EntityManagerInterface $em)
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
        if ($this->decisionManager->decide($token, array('ROLE_ALMOXARIFADO')) || $user->getProfessor() === true) {
            return true;
        } else {
            $config = $this->em->getRepository(Config::class)->getConfig();

            if($config && $config->getReservasFechadas() === true) {
                return false;
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
