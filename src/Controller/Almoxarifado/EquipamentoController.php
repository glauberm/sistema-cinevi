<?php

namespace App\Controller\Almoxarifado;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Swift_Mailer;
use Twig_Environment;
use App\Controller\Admin\AbstractCrudController;
use App\Mailer\MailerTrait;
use App\Entity\Equipamento;
use App\Entity\EquipamentoHistorico;
use App\Entity\CalendarEvent;
use App\Form\Almoxarifado\EquipamentoType;

class EquipamentoController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'almoxarifado_equipamento';
    protected $templateDir = 'almoxarifado/equipamento';
    protected $repositoryName = Equipamento::class;
    protected $historicoRepository = EquipamentoHistorico::class;
    protected $className = Equipamento::class;
    protected $formClassName = EquipamentoType::class;
    protected $paramsKey = 'id';
    private $manutencao;
    private $atrasado;

    protected function preShow(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator, $obj, array $data = []) : array
    {
        $r = $em->getRepository(CalendarEvent::class);

        $qb = $r->list($ac, 'reserva');

        $qb = $r->listWhereEquipamentoIs($qb, $obj->getId(), 'reserva');

        $pagination = $this->createPagination($request, $paginator, $qb);

        $data['pagination'] = $pagination;

        return $data;
    }

    protected function preFormEdit($obj, Form $form, EntityManagerInterface $em) : Form
    {
        $this->manutencao = $obj->getManutencao();
        $this->atrasado = $obj->getAtrasado();

        return $form;
    }

    protected function postEdit($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        if($this->manutencao == false && $obj->getManutencao() == true) {
            $subject = 'Manutenção de Equipamento: '.$obj->getNome();
            $template = $this->templateDir.'/email';
            foreach($obj->getCalendarEvents() as $reserva) {
                if($reserva->getStartDate() > new \DateTime()) {
                    $path = $this->generateUrl('almoxarifado_reserva_show', array(
                        'params' => $reserva->getId()
                    ), UrlGeneratorInterface::ABSOLUTE_URL);
                    $to = $reserva->getUser()->getEmail();
                    $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);
                }
            }
        }

        if($this->atrasado == false && $obj->getAtrasado() == true) {
            $subject = 'Devolução Atrasada de Equipamento: '.$obj->getNome();
            $template = $this->templateDir.'/email_atrasado';
            foreach($obj->getCalendarEvents() as $reserva) {
                if($reserva->getStartDate() > new \DateTime()) {
                    $path = $this->generateUrl('almoxarifado_reserva_show', array(
                        'params' => $reserva->getId()
                    ), UrlGeneratorInterface::ABSOLUTE_URL);
                    $to = $reserva->getUser()->getEmail();
                    $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);
                }
            }
        }
    }
}
