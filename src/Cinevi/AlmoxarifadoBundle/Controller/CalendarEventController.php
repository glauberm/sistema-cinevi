<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent;
use Cinevi\AlmoxarifadoBundle\Form\Type\CalendarEventType;

class CalendarEventController extends RestfulCrudController
{
    use MailerTrait;

    protected $bundleName = 'CineviAlmoxarifadoBundle:CalendarEvent';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:CalendarEvent';
    protected $className = CalendarEvent::class;
    protected $routeSuffix = 'calendar_event';
    protected $label = 'reserva';
    protected $formClassName = CalendarEventType::class;

    protected function preCriar(Form $form, EntityManager $em)
    {
        $reservas = $em->getRepository($this->repositoryName)->findAll();

        $form = $this->checaReservas($form, $reservas);

        return $form;
    }

    protected function preEditar($obj, Form $form, EntityManager $em)
    {
        $reservas = $em->createQuery('SELECT c FROM '.$this->className.' c WHERE c.id != '.$obj->getId())->getResult();

        $form = $this->checaReservas($form, $reservas);

        return $form;
    }

    protected function posCriar($obj, EntityManager $em)
    {
        $template = $this->bundleName.':email';

        $assunto = 'Nova Reserva de Equipamento: '.$obj->getTitle();

        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'id' => $obj->getId(),
        ), true);

        // Envia email para os emails no array
        $emails = array(
            $obj->getUser()->getEmail(),
            $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail(),
            'almoxarifadocinemauff@gmail.com',
        );

        foreach($emails as $email) {
            $destinatario = $email;
            $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);
        }

        return $obj;
    }

    private function checaReservas($form, $reservas)
    {
        $interval = \DateInterval::createFromDateString('1 day');

        $fStartDate = $form->get('startDate')->getData();
        $fEndDate = $form->get('endDate')->getData();

        $fPeriod = new \DatePeriod($fStartDate, $interval, $fEndDate);

        foreach( $reservas as $reserva ) {

            foreach( $reserva->getEquipamentos() as $rEquipamento ) {
                foreach( $form->get('equipamentos')->getData() as $fEquipamento ) {

                    if( $rEquipamento == $fEquipamento ) {

                        $rStartDate = $reserva->getStartDate();
                        $rEndDate = $reserva->getEndDate();
                        $rPeriod = new \DatePeriod($rStartDate, $interval, $rEndDate);

                        foreach ( $rPeriod as $rDay ) {
                            foreach ( $fPeriod as $fDay ) {
                                if($rDay == $fDay) {
                                    $mensagem = $rEquipamento->getNome().' já está reservado do dia '.$reserva->getStartDate()->format('d/m/Y').' ao '.$reserva->getEndDate()->format('d/m/Y').'.';

                                    $form->get('startDate')->addError(new FormError($mensagem));
                                    $form->get('endDate')->addError(new FormError($mensagem));

                                    break 3;
                                }
                            }
                        }

                    }

                }
            }

        }

        return $form;
    }
}
