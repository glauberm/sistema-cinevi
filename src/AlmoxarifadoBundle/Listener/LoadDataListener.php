<?php

namespace AlmoxarifadoBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AlmoxarifadoBundle\Entity\CalendarEvent as Event;

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

        $reservas = $this->em->getRepository('AlmoxarifadoBundle:CalendarEvent')->findAll();

        $userAtual = $this->container->get('security.context')->getToken()->getUser();

        foreach($reservas as $reserva)
        {
            $event = new Event();

            $equipamentos = array();

            foreach( $reserva->getEquipamentos() as $equipamento ) {
                $equipamentos[] = '['.$equipamento->getCodigo().'] '.$equipamento->getNome();
            }

            $event->setTitle( $reserva->getTitle()." (".$reserva->getUser()->getUsername()."): ".implode(", ", $equipamentos)." - De ". $reserva->getStartDate()->format("d/m/Y") . " a " . $reserva->getEndDate()->format("d/m/Y"));

            $event->setStartDate($reserva->getStartDate());
            $event->setEndDate($reserva->getEndDate()->add(new \DateInterval('P1D')));

            $url = $this->container->get('router')->generate('almoxarifado_reserva_show', array(
                'params' => $reserva->getId(),
            ));
            $event->setUrl($url);

            if($reserva->getUser() == $userAtual) {
                $event->setClassName('reserva reserva-propria');
            } else {
                $event->setClassName('reserva');
            }

            $calendarEvent->addEvent($event);
        }
    }
}
