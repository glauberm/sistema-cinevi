<?php

namespace Cinevi\AlmoxarifadoBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent as Event;

class LoadDataListener
{
    private $em;
    private $container;
    private $authorizationChecker;
    private $token;

    public function __construct(EntityManager $em, ContainerInterface $container, AuthorizationCheckerInterface $authorizationChecker, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->container = $container;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return EventInterface[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStart();
        $endDate = $calendarEvent->getEnd();
        $filters = $calendarEvent->getFilters();

        // Pega os eventos
        $reservas = $this->em->getRepository('CineviAlmoxarifadoBundle:CalendarEvent')->findAll();

        // Constrói no calendário
        foreach($reservas as $reserva)
        {
            $event = new Event();

            $equipamentos = array();
            foreach( $reserva->getEquipamentos() as $equipamento ) {
                $equipamentos[] = $equipamento->getNome();
            }

            $event->setTitle( $reserva->getTitle()."\n".$reserva->getUser()->getUsername()." – ".implode(", ", $equipamentos) );
            $event->setStartDate($reserva->getStartDate());
            $event->setEndDate($reserva->getEndDate()->add(new \DateInterval('P1D')));

            // URL
            if(($this->authorizationChecker->isGranted('ROLE_FUNCIONARIO')) || ($this->tokenStorage->getUser() == $obj->getUser())) {
                $urlString = 'edit_calendar_event';
            } else {
                $urlString = 'get_calendar_event';
            }
            $url = $this->container->get('router')->generate($urlString, array(
                'id' => $reserva->getId(),
            ));
            $event->setUrl($url);

            // Colors
            $event->setBackgroundColor('#EAD741');
            $event->setTextColor('#333333');

            $calendarEvent->addEvent($event);
        }
    }
}
