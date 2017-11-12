<?php

namespace Cinevi\AlmoxarifadoBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Yasumi\Yasumi;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent;
use Cinevi\AlmoxarifadoBundle\Form\Type\CalendarEventType;

/**
 * @RouteResource("reservas", pluralize=false)
 */
class ReservaController extends RestfulCrudController
{
    protected $bundleName = 'CineviAlmoxarifadoBundle:CalendarEvent';
    protected $repositoryName = 'CineviAlmoxarifadoBundle:CalendarEvent';
    protected $className = CalendarEvent::class;
    protected $routeSuffix = 'reservas';
    protected $formClassName = CalendarEventType::class;
    protected $paramsKey = 'id';

    use MailerTrait;

    protected function postFormPost(Form $form, EntityManager $em) : Form
    {
        $startDate = $form->get('startDate')->getData();
        $endDate = $form->get('endDate')->getData();

        $form = $this->validateWeekend($startDate, $endDate, $form);
        $form = $this->validateHoliday($startDate, $endDate, $form);
        $form = $this->validateInterval($startDate, $endDate, $form);

        $reservas = $em->getRepository($this->repositoryName)
            ->findAllBetweenDates($startDate, $endDate)
            ->getQuery()->getResult()
        ;

        $form = $this->validateEquipamentos($startDate, $endDate, $form, $reservas);

        return $form;
    }

    protected function postFormPut($obj, Form $form, EntityManager $em) : Form
    {
        $startDate = $form->get('startDate')->getData();
        $endDate = $form->get('endDate')->getData();

        $form = $this->validateWeekend($startDate, $endDate, $form);
        $form = $this->validateHoliday($startDate, $endDate, $form);
        $form = $this->validateInterval($startDate, $endDate, $form);

        $reservas = $em->getRepository($this->repositoryName)
            ->findAllBetweenDatesButId($startDate, $endDate, $obj->getId())
            ->getQuery()->getResult()
        ;

        $form = $this->validateEquipamentos($startDate, $endDate, $form, $reservas);

        return $form;
    }

    protected function postPost($obj, EntityManager $em)
    {
        $subject = 'Nova Reserva: '.$obj->getTitle();
        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'params' => $obj->getId(),
        ), true);

        $template = $this->bundleName.':email';
        $to = 'almoxarifadocinemauff@gmail.com';
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-user';
        $to = $obj->getUser()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-professor';
        $to = $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $this->get('session')->getFlashBag()->set('success', 'Criação de reserva realizada com sucesso! Para editar ou excluir sua reserva, clique nela pelo calendário.');
    }

    protected function postPut($obj, EntityManager $em)
    {
        $subject = 'Edição de Reserva: '.$obj->getTitle();
        $path = $this->generateUrl('get_'.$this->routeSuffix, array(
            'params' => $obj->getId(),
        ), true);

        $template = $this->bundleName.':email-edicao';
        $to = 'almoxarifadocinemauff@gmail.com';
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-edicao-user';
        $to = $obj->getUser()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        $template = $this->bundleName.':email-edicao-professor';
        $to = $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($this->container, $obj, $path, $subject, $to, $template);

        return $obj;
    }

    private function validateWeekend($startDate, $endDate, Form $form) : Form
    {
        if(!empty($startDate) && date('N', $startDate->format('U')) >= 6) {
            $mensagemStartDate = 'A data de retirada não pode cair nos finais de semana.';
            $form->get('startDate')->addError(new FormError($mensagemStartDate));
        }

        if(!empty($endDate) && date('N', $endDate->format('U')) >= 6) {
            $mensagemEndDate = 'A data de devolução não pode cair nos finais de semana.';
            $form->get('endDate')->addError(new FormError($mensagemEndDate));
        }

        return $form;
    }

    private function validateHoliday($startDate, $endDate, Form $form) : Form
    {
        if(!empty($startDate)) {
            $startDateYear = $startDate->format('Y');
            $holidaysByYear = Yasumi::create('Brazil', $startDateYear);
            foreach($holidaysByYear->getHolidayDates() as $holiday) {
                if($holiday == $startDate->format('Y-m-d')) {
                    $form->get('startDate')->addError(new FormError('A data de retirada não pode cair em um feriado.'));
                }
            }
        }

        if(!empty($endDate)) {
            $endDateYear = $endDate->format('Y');
            $holidaysByYear = Yasumi::create('Brazil', $endDateYear);
            foreach($holidaysByYear->getHolidayDates() as $holiday) {
                if($holiday == $endDate->format('Y-m-d')) {
                    $form->get('endDate')->addError(new FormError('A data de devolução não pode cair em um feriado.'));
                }
            }
        }

        return $form;
    }

    private function validateInterval($startDate, $endDate, Form $form) : Form
    {
        if(!empty($startDate)) {
            $hoje = new \DateTime();
            $diffStartDate = $hoje->diff($startDate);
            $intervalStartDate = (int)$diffStartDate->format("%r%a");
            if($intervalStartDate < 3) {
                $mensagemStartDate = 'As reservas precisam ser feitas com certa antecedência. O dia mais próximo no qual você pode marcar uma retirada é '.$hoje->add(new \DateInterval('P4D'))->format('d/m/Y').'.';

                $form->get('startDate')->addError(new FormError($mensagemStartDate));
            }

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

    private function validateEquipamentos($startDate, $endDate, Form $form, array $reservas)
    {
        $fEquipamentos = $form->get('equipamentos')->getData();

        if (!empty($fEquipamentos)) {
            foreach( $reservas as $reserva ) {
                foreach( $reserva->getEquipamentos() as $rEquipamento ) {
                    foreach( $fEquipamentos as $fEquipamento ) {
                        if( $rEquipamento == $fEquipamento ) {
                            $mensagem = '['.$fEquipamento->getCodigo().'] '.$fEquipamento->getNome().' está reservado de '.$reserva->getStartDate()->format('d/m/Y').' a '.$reserva->getEndDate()->format('d/m/Y').' pela reserva '.$reserva->getTitle().'.';

                            $form->get('equipamentos')->addError(new FormError($mensagem));

                            break;
                        }
                    }
                }
            }
        }

        return $form;
    }
}
