<?php

namespace App\Controller\Almoxarifado;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Swift_Mailer;
use Twig_Environment;
use Yasumi\Yasumi;
use App\Controller\Admin\AbstractCrudController;
use App\Mailer\MailerTrait;
use App\Entity\CalendarEvent;
use App\Entity\CalendarEventHistorico;
use App\Entity\Equipamento;
use App\Form\Almoxarifado\CalendarEventType;

class ReservaController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'almoxarifado_reserva';
    protected $templateDir = 'almoxarifado/calendar_event';
    protected $repositoryName = CalendarEvent::class;
    protected $historicoRepository = CalendarEventHistorico::class;
    protected $className = CalendarEvent::class;
    protected $formClassName = CalendarEventType::class;
    protected $paramsKey = 'id';

    protected function preShow(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator, $obj, array $data = []) : array
    {
        $r = $em->getRepository(Equipamento::class);

        $qb = $r->list($ac, 'equipamento');

        $qb = $r->listWhereReservaIs($qb, $obj->getId(), 'equipamento');

        $pagination = $this->createPagination($request, $paginator, $qb);

        $data['pagination'] = $pagination;

        return $data;
    }

    protected function postFormNew(Form $form, EntityManagerInterface $em, AuthorizationCheckerInterface $ac) : Form
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

    protected function postFormEdit($obj, Form $form, EntityManagerInterface $em, AuthorizationCheckerInterface $ac) : Form
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

    protected function postNew($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $subject = 'Nova Reserva: '.$obj->getTitle();
        $path = $this->generateUrl($this->canonicalName.'_show', array(
            'params' => $obj->getId(),
        ), UrlGeneratorInterface::ABSOLUTE_URL);

        $template = $this->templateDir.'/email';
        $to = 'almoxarifadocinemauff@gmail.com';
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_user';
        $to = $obj->getUser()->getEmail();
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_professor';
        $to = $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

        $session->getFlashBag()->set('success', 'Criação de reserva realizada com sucesso! Para editar ou excluir sua reserva, clique nela pelo calendário.');
    }

    protected function postEdit($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $subject = 'Edição de Reserva: '.$obj->getTitle();
        $path = $this->generateUrl($this->canonicalName.'_show', array(
            'params' => $obj->getId(),
        ), UrlGeneratorInterface::ABSOLUTE_URL);

        $template = $this->templateDir.'/email_edicao';
        $to = 'almoxarifadocinemauff@gmail.com';
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_edicao_user';
        $to = $obj->getUser()->getEmail();
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

        $template = $this->templateDir.'/email_edicao_professor';
        $to = $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail();
        $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);

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
