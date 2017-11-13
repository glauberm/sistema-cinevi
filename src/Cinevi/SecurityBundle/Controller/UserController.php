<?php

namespace Cinevi\SecurityBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Cinevi\AdminBundle\Controller\RestfulCrudController;
use Cinevi\AdminBundle\Mailer\MailerTrait;
use Cinevi\SecurityBundle\Entity\User;
use Cinevi\SecurityBundle\Form\Type\UserType;

/**
 * @RouteResource("usuarios", pluralize=false)
 */
class UserController extends RestfulCrudController implements ClassResourceInterface
{
    use MailerTrait;

    protected $bundleName = 'CineviSecurityBundle:User';
    protected $repositoryName = 'CineviSecurityBundle:User';
    protected $className = User::class;
    protected $routeSuffix = 'usuarios';
    protected $formClassName = UserType::class;
    protected $paramsKey = 'id';
    private $confirmed;

    protected function preGet(Request $request, EntityManager $em, $obj, array $return = []) : array
    {
        $rReserva = $em->getRepository('CineviAlmoxarifadoBundle:CalendarEvent');
        $rProjeto = $em->getRepository('CineviRealizacaoBundle:Projeto');
        $rCopiaFinal = $em->getRepository('CineviRealizacaoBundle:CopiaFinal');

        $qbReserva = $rReserva->list('reserva');
        $qbReserva = $this->list($request, $em, $qbReserva, 'reserva');
        $qbProjeto = $rProjeto->list('projeto');
        $qbProjeto = $this->list($request, $em, $qbProjeto, 'projeto');
        $qbCopiaFinal = $rCopiaFinal->list('copiaFinal');
        $qbCopiaFinal = $this->list($request, $em, $qbCopiaFinal, 'copiaFinal');

        $qbReserva = $rReserva->listWhereUserIs($qbReserva, $obj->getId(), 'reserva');
        $qbProjeto = $rProjeto->listWhereUserIs($qbProjeto, $obj->getId(), 'projeto');
        $qbCopiaFinal = $rCopiaFinal->listWhereUserIs($qbCopiaFinal, $obj->getId(), 'copiaFinal');

        $paginationReserva = $this->getPagination($request, $qbReserva, 'Reserva');
        $paginationProjeto = $this->getPagination($request, $qbProjeto, 'Projeto');
        $paginationCopiaFinal = $this->getPagination($request, $qbCopiaFinal, 'CopiaFinal');

        $return['paginationReserva'] = $paginationReserva;
        $return['paginationProjeto'] = $paginationProjeto;
        $return['paginationCopiaFinal'] = $paginationCopiaFinal;

        return $return;
    }

    protected function preFormPut($obj, Form $form, EntityManager $em) : Form
    {
        $this->confirmed = $obj->getConfirmado();

        return $form;
    }

    protected function postPut($obj, EntityManager $em)
    {
        if($this->confirmed == false && $obj->getConfirmado() == true) {
            $subject = 'Confirmação de Cadastro: '.$obj->getUsername();
            $path = $this->generateUrl('index', array(), true);
            $template = $this->bundleName.':email';
            $to = $obj->getEmail();
            $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
        }

        return $obj;
    }
}
