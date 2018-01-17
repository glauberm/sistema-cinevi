<?php

namespace App\Controller\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Controller\Admin\AbstractCrudController;
use App\Mailer\MailerTrait;
use App\Entity\User;
use App\Form\User\UserType;

class UserController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'user_user';
    protected $templateDir = 'user/user';
    protected $repositoryName = 'App\Entity\User';
    protected $className = User::class;
    protected $formClassName = UserType::class;
    protected $paramsKey = 'id';
    private $confirmed;

    protected function preShow(Request $request, EntityManager $em, $obj, array $data = []) : array
    {
        $rReserva = $em->getRepository('App\Entity\CalendarEvent');
        $rProjeto = $em->getRepository('App\Entity\Projeto');
        $rCopiaFinal = $em->getRepository('App\Entity\CopiaFinal');

        $qbReserva = $rReserva->list($this->get('security.authorization_checker'), 'reserva');
        $qbProjeto = $rProjeto->list($this->get('security.authorization_checker'), 'projeto');
        $qbCopiaFinal = $rCopiaFinal->list($this->get('security.authorization_checker'), 'copiaFinal');

        $qbReserva = $rReserva->listWhereUserIs($qbReserva, $obj->getId(), 'reserva');
        $qbProjeto = $rProjeto->listWhereUserIs($qbProjeto, $obj->getId(), 'projeto');
        $qbCopiaFinal = $rCopiaFinal->listWhereUserIs($qbCopiaFinal, $obj->getId(), 'copiaFinal');

        $paginationReserva = $this->createPagination($request, $this->get('knp_paginator'), $qbReserva, 'Reserva');
        $paginationProjeto = $this->createPagination($request, $this->get('knp_paginator'), $qbProjeto, 'Projeto');
        $paginationCopiaFinal = $this->createPagination($request, $this->get('knp_paginator'), $qbCopiaFinal, 'CopiaFinal');

        $data['paginationReserva'] = $paginationReserva;
        $data['paginationProjeto'] = $paginationProjeto;
        $data['paginationCopiaFinal'] = $paginationCopiaFinal;

        return $data;
    }

    protected function preFormEdit($obj, Form $form, EntityManager $em) : Form
    {
        $this->confirmed = $obj->getConfirmado();

        return $form;
    }

    protected function postEdit($obj, EntityManager $em)
    {
        if($this->confirmed == false && $obj->getConfirmado() == true) {
            $subject = 'Confirmação de Cadastro: '.$obj->getUsername();
            $path = $this->generateUrl('index', array(), UrlGeneratorInterface::ABSOLUTE_URL);
            $template = $this->templateDir.'/email';
            $to = $obj->getEmail();
            $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
        }

        return $obj;
    }
}
