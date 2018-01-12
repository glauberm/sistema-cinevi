<?php

namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use AdminBundle\Controller\AbstractCrudController;
use AdminBundle\Mailer\MailerTrait;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;

class UserController extends AbstractCrudController
{
    use MailerTrait;

    protected $canonicalName = 'user_user';
    protected $bundleName = 'UserBundle:User';
    protected $repositoryName = 'UserBundle:User';
    protected $className = User::class;
    protected $formClassName = UserType::class;
    protected $paramsKey = 'id';
    private $confirmed;

    protected function preShow(Request $request, EntityManager $em, $obj, array $data = []) : array
    {
        $rReserva = $em->getRepository('AlmoxarifadoBundle:CalendarEvent');
        $rProjeto = $em->getRepository('RealizacaoBundle:Projeto');
        $rCopiaFinal = $em->getRepository('RealizacaoBundle:CopiaFinal');

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
            $path = $this->generateUrl('index', array(), true);
            $template = $this->bundleName.':email';
            $to = $obj->getEmail();
            $this->sendMail($this->container, $obj, $path, $subject, $to, $template);
        }

        return $obj;
    }
}
