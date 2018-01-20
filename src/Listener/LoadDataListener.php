<?php

namespace App\Listener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\RouterInterface;
use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use App\Entity\CalendarEvent as Event;

class LoadDataListener
{
    private $em;
    private $token;
    private $router;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $token, RouterInterface $router)
    {
        $this->em = $em;
        $this->token = $token;
        $this->router = $router;
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

        $reservas = $this->em->getRepository(Event::class)->findAll();
        $userAtual = $this->token->getToken()->getUser();

        foreach($reservas as $reserva)
        {
            $event = new Event();

            $event->setTitle( $reserva->getTitle()." (".$reserva->getUser()->getUsername().") - De ". $reserva->getStartDate()->format("d/m/Y") . " a " . $reserva->getEndDate()->format("d/m/Y"));
            $event->setStartDate($reserva->getStartDate());
            $event->setEndDate($reserva->getEndDate()->add(new \DateInterval('P1D')));
            $event->setUrl($this->router->generate('almoxarifado_reserva_show', array(
                'params' => $reserva->getId(),
            )));

            if($reserva->getUser() == $userAtual) {
                $event->setClassName('reserva reserva-propria');
            } else {
                $event->setClassName('reserva');
            }

            $calendarEvent->addEvent($event);
        }
    }
}
