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
use Yasumi\Yasumi;

class CalendarEventController extends RestfulCrudController
{
    use MailerTrait;

    protected $bundleName = 'CineviAlmoxarifadoBundle:CalendarEvent';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:CalendarEvent';
    protected $className = CalendarEvent::class;
    protected $routeSuffix = 'calendar_event';
    protected $formClassName = CalendarEventType::class;

    protected function posCriar(Form $form, EntityManager $em)
    {
        $form = $this->checaFimDeSemana($form);
        $form = $this->checaFeriado($form);
        $form = $this->checaIntervalo($form);

        $reservas = $em->getRepository($this->repositoryName)->findAll();

        $form = $this->checaReservas($form, $reservas);

        return $form;
    }

    protected function posEditar($obj, Form $form, EntityManager $em)
    {
        $form = $this->checaFimDeSemana($form);
        $form = $this->checaFeriado($form);
        $form = $this->checaIntervalo($form);

        $reservas = $em->createQuery('SELECT c FROM '.$this->className.' c WHERE c.id != '.$obj->getId())->getResult();

        $form = $this->checaReservas($form, $reservas);

        return $form;
    }

    protected function posPersist($obj, EntityManager $em)
    {
        $assunto = 'Nova Reserva: '.$obj->getTitle();

        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'id' => $obj->getId(),
        ), true);

        // Email para o almoxarifado
        $destinatario = 'almoxarifadocinemauff@gmail.com';
        $template = $this->bundleName.':email';

        $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);

        // Email para o usuário
        $destinatario = $obj->getUser()->getEmail();
        $template = $this->bundleName.':email-user';

        $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);

        // Email para o professor
        $destinatario = $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail();
        $template = $this->bundleName.':email-professor';

        $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);

        $this->get('session')->getFlashBag()->set('success', 'Criação de reserva realizada com sucesso! Para editar ou excluir sua reserva, clique nela pelo calendário.');

        return $obj;
    }

    protected function posMerge($obj, EntityManager $em)
    {
        $assunto = 'Edição de Reserva: '.$obj->getTitle();

        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'id' => $obj->getId(),
        ), true);

        // Email para o almoxarifado
        $destinatario = 'almoxarifadocinemauff@gmail.com';
        $template = $this->bundleName.':email-edicao';

        $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);

        // Email para o usuário
        $destinatario = $obj->getUser()->getEmail();
        $template = $this->bundleName.':email-edicao-user';

        $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);

        // Email para o professor
        $destinatario = $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail();
        $template = $this->bundleName.':email-edicao-professor';

        $this->sendMail($this->container, $obj, $path, $assunto, $destinatario, $template);

        return $obj;
    }

    private function checaFimDeSemana($form)
    {
        $startDate = $form->get('startDate')->getData();

        if(!empty($startDate) && date('N', $startDate->format('U')) >= 6) {
            $mensagemStartDate = 'A data de retirada não pode cair nos finais de semana.';
            $form->get('startDate')->addError(new FormError($mensagemStartDate));
        }

        $endDate = $form->get('endDate')->getData();

        if(!empty($endDate) && date('N', $endDate->format('U')) >= 6) {
            $mensagemEndDate = 'A data de devolução não pode cair nos finais de semana.';
            $form->get('endDate')->addError(new FormError($mensagemEndDate));
        }

        return $form;
    }

    private function checaFeriado($form)
    {
        $startDate = $form->get('startDate')->getData();

        if(!empty($startDate)) {
            $startDateYear = $startDate->format('Y');
            $startDateHolidays = Yasumi::create('Brazil', $startDateYear);

            foreach($startDateHolidays->getHolidayDates() as $holiday) {
                if($holiday == $startDate->format('Y-m-d')) {
                    $form->get('startDate')->addError(new FormError('A data de retirada não pode cair em um feriado.'));
                }
            }
        }

        $endDate = $form->get('endDate')->getData();

        if(!empty($endDate)) {
            $endDateYear = $endDate->format('Y');
            $endDateHolidays = Yasumi::create('Brazil', $endDateYear);

            foreach($endDateHolidays->getHolidayDates() as $holiday) {
                if($holiday == $endDate->format('Y-m-d')) {
                    $form->get('endDate')->addError(new FormError('A data de devolução não pode cair em um feriado.'));
                }
            }
        }

        return $form;
    }

    private function checaIntervalo($form)
    {
        // Pega o intervalo entre hoje e o dia de retirada
        $startDate = $form->getData()->getStartDate();

        if(!empty($startDate)) {
            $hoje = new \DateTime();
            $diffStartDate = $hoje->diff($startDate);
            $intervalStartDate = (int)$diffStartDate->format("%r%a");

            if($intervalStartDate < 3) {
                $mensagemStartDate = 'As reservas precisam ser feitas com certa antecedência. O dia mais próximo no qual você pode marcar uma retirada é '.$hoje->add(new \DateInterval('P4D'))->format('d/m/Y').'.';

                $form->get('startDate')->addError(new FormError($mensagemStartDate));
            }

            // Pega o intervalo entre o dia de retirada e o dia de devolução
            $endDate = $form->getData()->getEndDate();

            if(!empty($endDate)) {
                $diffEndDate = $startDate->diff($endDate);
                $intervalEndDate = (int)$diffEndDate->format("%r%a");

                if($intervalEndDate < 0) {
                    $mensagemEndDate = 'As devoluções precisam ser feitas algum tempo depois da retirada. O dia mais próximo no qual você pode marcar uma devolução para esta data de retirada é '.$startDate->format('d/m/Y').'.';

                    $form->get('endDate')->addError(new FormError($mensagemEndDate));
                }
            }
        }

        return $form;
    }

    private function checaReservas($form, $reservas)
    {
        $interval = \DateInterval::createFromDateString('1 day');

        $fStartDate = $form->get('startDate')->getData();
        $fEndDate = $form->get('endDate')->getData();
        $fEquipamentos = $form->get('equipamentos')->getData();

        if(!empty($fStartDate) && !empty($fEndDate) && !empty($fEquipamentos)) {
            if($fStartDate == $fEndDate) {
                $fEndDate->add($interval);
            }

            $fPeriod = new \DatePeriod($fStartDate, $interval, $fEndDate);

            foreach( $reservas as $reserva ) {
                foreach( $reserva->getEquipamentos() as $rEquipamento ) {
                    foreach( $fEquipamentos as $fEquipamento ) {
                        if( $rEquipamento == $fEquipamento ) {
                            $rStartDate = $reserva->getStartDate();
                            $rEndDate = $reserva->getEndDate();

                            if($rStartDate == $rEndDate) {
                                $rEndDate->add($interval);
                            }

                            $rPeriod = new \DatePeriod($rStartDate, $interval, $rEndDate);

                            foreach ($rPeriod as $rDay) {
                                foreach ($fPeriod as $fDay) {

                                    if( $rDay == $fDay ) {
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
        }

        return $form;
    }
}
