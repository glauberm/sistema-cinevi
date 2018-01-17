<?php

namespace App\Controller\User;

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
use App\Entity\User;
use App\Entity\CalendarEvent;
use App\Entity\Projeto;
use App\Entity\CopiaFinal;
use App\Form\User\UserType;

class UserController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'user_user';
    protected $templateDir = 'user/user';
    protected $repositoryName = User::class;
    protected $className = User::class;
    protected $formClassName = UserType::class;
    protected $paramsKey = 'id';
    private $confirmed;

    protected function preShow(Request $request, EntityManagerInterface $em, AuthorizationCheckerInterface $ac, PaginatorInterface $paginator, $obj, array $data = []) : array
    {
        $rReserva = $em->getRepository(CalendarEvent::class);
        $rProjeto = $em->getRepository(Projeto::class);
        $rCopiaFinal = $em->getRepository(CopiaFinal::class);

        $qbReserva = $rReserva->list($ac, 'reserva');
        $qbProjeto = $rProjeto->list($ac, 'projeto');
        $qbCopiaFinal = $rCopiaFinal->list($ac, 'copiaFinal');

        $qbReserva = $rReserva->listWhereUserIs($qbReserva, $obj->getId(), 'reserva');
        $qbProjeto = $rProjeto->listWhereUserIs($qbProjeto, $obj->getId(), 'projeto');
        $qbCopiaFinal = $rCopiaFinal->listWhereUserIs($qbCopiaFinal, $obj->getId(), 'copiaFinal');

        $paginationReserva = $this->createPagination($request, $paginator, $qbReserva, 'Reserva');
        $paginationProjeto = $this->createPagination($request, $paginator, $qbProjeto, 'Projeto');
        $paginationCopiaFinal = $this->createPagination($request, $paginator, $qbCopiaFinal, 'CopiaFinal');

        $data['paginationReserva'] = $paginationReserva;
        $data['paginationProjeto'] = $paginationProjeto;
        $data['paginationCopiaFinal'] = $paginationCopiaFinal;

        return $data;
    }

    protected function preFormEdit($obj, Form $form, EntityManagerInterface $em) : Form
    {
        $this->confirmed = $obj->getConfirmado();

        return $form;
    }

    protected function postEdit($obj, EntityManagerInterface $em, SessionInterface $session, Swift_Mailer $mailer, Twig_Environment $twig)
    {
        if($this->confirmed == false && $obj->getConfirmado() == true) {
            $subject = 'Confirmação de Cadastro: '.$obj->getUsername();
            $path = $this->generateUrl('index', array(), UrlGeneratorInterface::ABSOLUTE_URL);
            $template = $this->templateDir.'/email';
            $to = $obj->getEmail();
            $this->sendMail($mailer, $twig, $obj, $path, $subject, $to, $template);
        }

        return $obj;
    }
}
