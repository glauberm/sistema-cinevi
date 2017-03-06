<?php

namespace Cinevi\AlmoxarifadoBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent as Event;

class LoadDataListener
{
    private $em;
    private $container;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
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

            $event->setTitle( $reserva->getTitle()." (".$reserva->getUser()->getUsername().") - ".implode(", ", $equipamentos) );
            $event->setStartDate($reserva->getStartDate());
            $event->setEndDate($reserva->getEndDate()->add(new \DateInterval('P1D')));

            // URL
            $url = $this->container->get('router')->generate('get_calendar_event', array(
                'id' => $reserva->getId(),
            ));
            $event->setUrl($url);

            $calendarEvent->addEvent($event);
        }
    }
}
