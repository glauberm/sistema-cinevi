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

        // Pega o user atual
        $userAtual = $this->container->get('security.context')->getToken()->getUser();

        // Constrói no calendário
        foreach($reservas as $reserva)
        {
            $event = new Event();

            // Constrói um array dos equipamentos e coloca no título
            $equipamentos = array();

            foreach( $reserva->getEquipamentos() as $equipamento ) {
                $equipamentos[] = '['.$equipamento->getCodigo().'] '.$equipamento->getNome();
            }

            $event->setTitle( $reserva->getTitle()." (".$reserva->getUser()->getUsername().") - ".implode(", ", $equipamentos) );

            // Data de Início e Fim
            $event->setStartDate($reserva->getStartDate());
            $event->setEndDate($reserva->getEndDate()->add(new \DateInterval('P1D')));

            // URL
            $url = $this->container->get('router')->generate('get_reserva', array(
                'id' => $reserva->getId(),
            ));
            $event->setUrl($url);

            // Classe se for user atual ou não
            if($reserva->getUser() == $userAtual) {
                $event->setClassName('reserva reserva-propria');
            } else {
                $event->setClassName('reserva');
            }

            $calendarEvent->addEvent($event);
        }
    }
}
